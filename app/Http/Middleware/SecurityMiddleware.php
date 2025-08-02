<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log suspicious patterns
        $this->logSuspiciousPatterns($request);

        // Sanitize input data
        $this->sanitizeInput($request);

        // Add security headers
        $response = $next($request);

        return $this->addSecurityHeaders($response);
    }

    /**
     * Log suspicious patterns in request data.
     */
    private function logSuspiciousPatterns(Request $request): void
    {
        $suspiciousPatterns = [
            'script',
            'javascript:',
            'vbscript:',
            'onload',
            'onerror',
            'eval(',
            'DROP TABLE',
            'DELETE FROM',
            'INSERT INTO',
            'UPDATE SET',
            'UNION SELECT',
            '<script',
            '</script>',
            'xp_cmdshell',
            'sp_executesql',
        ];

        $inputData = json_encode($request->all());

        foreach ($suspiciousPatterns as $pattern) {
            if (stripos($inputData, $pattern) !== false) {
                Log::warning('Suspicious pattern detected', [
                    'pattern' => $pattern,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'input' => $request->all(),
                ]);
                break;
            }
        }
    }

    /**
     * Sanitize input data.
     */
    private function sanitizeInput(Request $request): void
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                // Remove null bytes
                $value = str_replace("\0", '', $value);

                // Trim whitespace
                $value = trim($value);

                // Basic XSS protection (strip script tags)
                $value = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $value);
            }
        });

        $request->replace($input);
    }

    /**
     * Add security headers to response.
     */
    private function addSecurityHeaders(Response $response): Response
    {
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Only add HSTS for HTTPS
        if (request()->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
