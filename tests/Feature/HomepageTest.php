<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * Test homepage loads successfully and redirects to admin.
     */
    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/admin');
    }

    /**
     * Test home route also redirects to admin.
     */
    public function test_home_route_redirects_to_admin(): void
    {
        $response = $this->get('/home');
        $response->assertStatus(302);
        $response->assertRedirect('/admin');
    }
}