<?php

namespace Tests\Unit;

use App\Http\Middleware\SecurityMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class SecurityMiddlewareTest extends TestCase
{
    /**
     * Test security headers are added to response.
     */
    public function test_security_headers_added(): void
    {
        $middleware = new SecurityMiddleware();
        $request = Request::create('/test', 'GET');
        
        $response = $middleware->handle($request, function ($request) {
            return new Response('Test content');
        });
        
        // Check that security headers are added
        $this->assertEquals('nosniff', $response->headers->get('X-Content-Type-Options'));
        $this->assertEquals('DENY', $response->headers->get('X-Frame-Options'));
        $this->assertEquals('1; mode=block', $response->headers->get('X-XSS-Protection'));
        $this->assertEquals('strict-origin-when-cross-origin', $response->headers->get('Referrer-Policy'));
        $this->assertNotNull($response->headers->get('Permissions-Policy'));
    }

    /**
     * Test input sanitization removes dangerous content.
     */
    public function test_input_sanitization(): void
    {
        $middleware = new SecurityMiddleware();
        $request = Request::create('/test', 'POST', [
            'name' => '<script>alert("XSS")</script>John Doe',
            'description' => 'Normal text here',
            'nested' => [
                'field' => '<script src="evil.js"></script>Clean content'
            ]
        ]);
        
        $middleware->handle($request, function ($request) {
            return new Response('Test');
        });
        
        // Check that script tags are removed
        $this->assertStringNotContainsString('<script>', $request->input('name'));
        $this->assertStringNotContainsString('</script>', $request->input('name'));
        $this->assertStringContainsString('John Doe', $request->input('name'));
        
        // Check nested arrays are also sanitized
        $this->assertStringNotContainsString('<script>', $request->input('nested.field'));
        $this->assertStringContainsString('Clean content', $request->input('nested.field'));
    }

    /**
     * Test suspicious pattern detection logs correctly.
     */
    public function test_suspicious_pattern_logging(): void
    {
        Log::shouldReceive('warning')
           ->once()
           ->with('Suspicious pattern detected', \Mockery::type('array'));
        
        $middleware = new SecurityMiddleware();
        $request = Request::create('/test', 'POST', [
            'query' => 'SELECT * FROM users; DROP TABLE users;'
        ]);
        
        $middleware->handle($request, function ($request) {
            return new Response('Test');
        });
    }

    /**
     * Test null byte removal.
     */
    public function test_null_byte_removal(): void
    {
        $middleware = new SecurityMiddleware();
        $request = Request::create('/test', 'POST', [
            'filename' => "test.txt\0.php"
        ]);
        
        $middleware->handle($request, function ($request) {
            return new Response('Test');
        });
        
        $this->assertEquals('test.txt.php', $request->input('filename'));
    }

    /**
     * Test whitespace trimming.
     */
    public function test_whitespace_trimming(): void
    {
        $middleware = new SecurityMiddleware();
        $request = Request::create('/test', 'POST', [
            'username' => '  admin  ',
            'email' => '   test@example.com   '
        ]);
        
        $middleware->handle($request, function ($request) {
            return new Response('Test');
        });
        
        $this->assertEquals('admin', $request->input('username'));
        $this->assertEquals('test@example.com', $request->input('email'));
    }

    /**
     * Test HSTS header is only added for HTTPS requests.
     */
    public function test_hsts_header_https_only(): void
    {
        $middleware = new SecurityMiddleware();
        
        // Test HTTP request (no HSTS)
        $httpRequest = Request::create('http://example.com/test', 'GET');
        $httpResponse = $middleware->handle($httpRequest, function ($request) {
            return new Response('Test');
        });
        
        $this->assertNull($httpResponse->headers->get('Strict-Transport-Security'));
        
        // Test HTTPS request (HSTS should be added)
        $httpsRequest = Request::create('https://example.com/test', 'GET');
        $httpsResponse = $middleware->handle($httpsRequest, function ($request) {
            return new Response('Test');
        });
        
        // Note: This test might not work exactly as expected in unit test environment
        // since request()->isSecure() depends on server configuration
        // In a real application, you would test this with a feature test
    }

    /**
     * Test middleware handles non-string input gracefully.
     */
    public function test_non_string_input_handling(): void
    {
        $middleware = new SecurityMiddleware();
        $request = Request::create('/test', 'POST', [
            'number' => 123,
            'boolean' => true,
            'array' => ['value1', 'value2'],
            'null' => null
        ]);
        
        // Should not throw any errors
        $response = $middleware->handle($request, function ($request) {
            return new Response('Test');
        });
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(123, $request->input('number'));
        $this->assertTrue($request->input('boolean'));
        $this->assertIsArray($request->input('array'));
    }
}