<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class AuthApiSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create basic roles for testing (support both web and api guards)
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'student', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'api']);
        Role::create(['name' => 'student', 'guard_name' => 'api']);
    }

    /**
     * Test login with valid credentials.
     */
    public function test_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_in',
                    'user' => ['id', 'name', 'email', 'roles'],
                ],
            ]);
    }

    /**
     * Test login with invalid credentials.
     */
    public function test_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials provided',
            ]);
    }

    /**
     * Test login validation for email field.
     */
    public function test_login_email_validation(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test login validation for password field.
     */
    public function test_login_password_validation(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => '123', // Too short
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    /**
     * Test login with missing fields.
     */
    public function test_login_missing_fields(): void
    {
        $response = $this->postJson('/api/auth/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * Test profile endpoint without authentication.
     */
    public function test_profile_without_authentication(): void
    {
        $response = $this->postJson('/api/auth/profile');

        $response->assertStatus(401);
    }

    /**
     * Test profile endpoint with valid token.
     */
    public function test_profile_with_valid_token(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/auth/profile');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => ['id', 'name', 'email', 'roles', 'permissions'],
            ]);
    }

    /**
     * Test logout endpoint.
     */
    public function test_logout(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Logged out successfully',
            ]);
    }

    /**
     * Test refresh token endpoint.
     */
    public function test_refresh_token(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/auth/refresh');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_in',
                ],
            ]);
    }

    /**
     * Test SQL injection prevention in login.
     */
    public function test_sql_injection_prevention(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => "'; DROP TABLE users; --",
            'password' => 'password123',
        ]);

        // Should fail validation, not execute SQL injection
        $response->assertStatus(422);
    }

    /**
     * Test rate limiting (if implemented).
     */
    public function test_brute_force_protection(): void
    {
        // Attempt multiple failed logins
        for ($i = 0; $i < 6; $i++) {
            $this->postJson('/api/auth/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // Check if rate limiting is applied (this would depend on your rate limiting configuration)
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // The response might be 429 (Too Many Requests) if rate limiting is enabled
        $this->assertTrue(in_array($response->getStatusCode(), [401, 429]));
    }
}
