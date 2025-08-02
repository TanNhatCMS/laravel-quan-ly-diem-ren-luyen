<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthApiTest extends TestCase
{
    /**
     * Test login API endpoint exists.
     */
    public function test_login_endpoint_exists(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // Should not return 404 (route exists)
        $this->assertNotEquals(404, $response->getStatusCode());
    }

    /**
     * Test logout endpoint exists.
     */
    public function test_logout_endpoint_exists(): void
    {
        $response = $this->postJson('/api/auth/logout');

        // This might return 401 (unauthorized) or 500, but the route should exist
        $this->assertNotEquals(404, $response->getStatusCode());
    }

    /**
     * Test refresh endpoint exists.
     */
    public function test_refresh_endpoint_exists(): void
    {
        $response = $this->postJson('/api/auth/refresh');

        // This might return 401 (unauthorized) or 500, but the route should exist
        $this->assertNotEquals(404, $response->getStatusCode());
    }

    /**
     * Test profile endpoint exists.
     */
    public function test_profile_endpoint_exists(): void
    {
        $response = $this->postJson('/api/auth/profile');

        // This might return 401 (unauthorized) or 500, but the route should exist
        $this->assertNotEquals(404, $response->getStatusCode());
    }
}
