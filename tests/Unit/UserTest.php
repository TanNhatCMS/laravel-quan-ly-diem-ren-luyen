<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Positions;
use App\Models\Classes;
use App\Models\Organizations;
use App\Models\UserProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user creation.
     */
    public function test_user_creation(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);
    }

    /**
     * Test user JWT identifier.
     */
    public function test_get_jwt_identifier(): void
    {
        $user = User::factory()->create();
        
        $this->assertEquals($user->getKey(), $user->getJWTIdentifier());
    }

    /**
     * Test JWT custom claims.
     */
    public function test_get_jwt_custom_claims(): void
    {
        $user = User::factory()->create();
        
        $this->assertIsArray($user->getJWTCustomClaims());
        $this->assertEquals([], $user->getJWTCustomClaims());
    }

    /**
     * Test user positions relationship.
     */
    public function test_user_positions_relationship(): void
    {
        $user = User::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $user->positions());
    }

    /**
     * Test user class relationship.
     */
    public function test_user_class_relationship(): void
    {
        $user = User::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $user->class());
    }

    /**
     * Test user organizations relationship.
     */
    public function test_user_organizations_relationship(): void
    {
        $user = User::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $user->organizations());
    }

    /**
     * Test user profile relationship.
     */
    public function test_user_profile_relationship(): void
    {
        $user = User::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class, $user->profile());
    }

    /**
     * Test user fillable attributes.
     */
    public function test_user_fillable_attributes(): void
    {
        $user = new User();
        $expected = ['name', 'email', 'password'];
        
        $this->assertEquals($expected, $user->getFillable());
    }

    /**
     * Test user hidden attributes.
     */
    public function test_user_hidden_attributes(): void
    {
        $user = new User();
        $expected = ['password', 'remember_token'];
        
        $this->assertEquals($expected, $user->getHidden());
    }
}