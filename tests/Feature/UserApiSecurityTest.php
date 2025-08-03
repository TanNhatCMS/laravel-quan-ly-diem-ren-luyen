<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class UserApiSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $adminUser;
    protected $token;
    protected $adminToken;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles (support both web and api guards)
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $studentRole = Role::create(['name' => 'student', 'guard_name' => 'web']);
        $apiAdminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $apiStudentRole = Role::create(['name' => 'student', 'guard_name' => 'api']);

        // Create test users
        $this->user = User::factory()->create();
        $this->user->assignRole('student');
        // Also assign API role for JWT context
        $this->user->assignRole($apiStudentRole);

        $this->adminUser = User::factory()->create([
            'email' => 'admin@example.com',
        ]);
        $this->adminUser->assignRole('admin');
        // Also assign API role for JWT context
        $this->adminUser->assignRole($apiAdminRole);

        // Generate tokens
        $this->token = JWTAuth::fromUser($this->user);
        $this->adminToken = JWTAuth::fromUser($this->adminUser);
    }

    /**
     * Test user list pagination validation.
     */
    public function test_user_list_pagination_validation(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->getJson('/api/users?per_page=1000'); // Exceeds max limit

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['per_page']);
    }

    /**
     * Test user list returns filtered data.
     */
    public function test_user_list_returns_filtered_data(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'data' => [
                        '*' => ['id', 'name', 'email', 'created_at', 'updated_at'],
                    ],
                    'current_page',
                    'total',
                ],
            ])
            ->assertJsonMissing(['password', 'remember_token']);
    }

    /**
     * Test user creation with invalid data.
     */
    public function test_user_creation_validation(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->postJson('/api/users', [
            'name' => 'A', // Too short
            'email' => 'invalid-email', // Invalid email
            'password' => '123', // Too short
            'password_confirmation' => '123', // Also too short but matches
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * Test user creation with duplicate email.
     */
    public function test_user_creation_duplicate_email(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->postJson('/api/users', [
            'name' => 'Test User',
            'email' => $this->user->email, // Duplicate email
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Test user creation with valid data.
     */
    public function test_user_creation_success(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->postJson('/api/users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'roles' => ['student'],
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['message', 'user_id']]);

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'name' => 'New User',
        ]);

        // Verify password is hashed
        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(password_verify('password123', $user->password));
    }

    /**
     * Test user profile access for non-existent user.
     */
    public function test_user_profile_not_found(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->getJson('/api/users/99999/profile');

        $response->assertStatus(404);
    }

    /**
     * Test user profile returns safe data.
     */
    public function test_user_profile_safe_data(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->getJson('/api/users/'.$this->user->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'created_at', 'updated_at', 'roles'],
            ])
            ->assertJsonMissing(['password', 'remember_token']);
    }

    /**
     * Test user deletion prevents self-deletion.
     */
    public function test_user_cannot_delete_self(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->deleteJson('/api/users/'.$this->adminUser->id);

        $response->assertStatus(403)
            ->assertJson(['message' => 'Cannot delete your own account']);
    }

    /**
     * Test user deletion for non-existent user.
     */
    public function test_user_deletion_not_found(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->deleteJson('/api/users/99999');

        $response->assertStatus(404);
    }

    /**
     * Test user deletion success.
     */
    public function test_user_deletion_success(): void
    {
        $userToDelete = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->deleteJson('/api/users/'.$userToDelete->id);

        $response->assertStatus(200)
            ->assertJson(['data' => ['message' => 'User has been deleted successfully']]);

        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    /**
     * Test role change validation.
     */
    public function test_role_change_validation(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->putJson('/api/users/'.$this->user->id.'/roles', [
            'roles' => ['nonexistent_role'],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['roles.0']);
    }

    /**
     * Test role change success.
     */
    public function test_role_change_success(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->putJson('/api/users/'.$this->user->id.'/roles', [
            'roles' => ['admin'],
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['message', 'roles']]);

        $this->assertTrue($this->user->fresh()->hasRole('admin'));
    }

    /**
     * Test unauthorized access without token.
     */
    public function test_unauthorized_access(): void
    {
        $endpoints = [
            ['GET', '/api/users'],
            ['POST', '/api/users'],
            ['GET', '/api/users/1'],
            ['DELETE', '/api/users/1'],
            ['PUT', '/api/users/1/roles'],
        ];

        foreach ($endpoints as [$method, $endpoint]) {
            $response = $this->json($method, $endpoint);
            $this->assertTrue(in_array($response->getStatusCode(), [401, 405])); // 401 Unauthorized or 405 Method Not Allowed
        }
    }

    /**
     * Test mass assignment protection.
     */
    public function test_mass_assignment_protection(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->adminToken,
        ])->postJson('/api/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'id' => 99999, // Should be ignored
            'created_at' => '2020-01-01', // Should be ignored
        ]);

        $response->assertStatus(200);

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotEquals(99999, $user->id);
        $this->assertNotEquals('2020-01-01', $user->created_at->format('Y-m-d'));
    }
}
