<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfilesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test UserProfiles model instantiation.
     */
    public function test_user_profiles_model_instantiation(): void
    {
        $userProfile = new UserProfiles();
        $this->assertInstanceOf(UserProfiles::class, $userProfile);
    }

    /**
     * Test UserProfiles table name.
     */
    public function test_user_profiles_table_name(): void
    {
        $userProfile = new UserProfiles();
        $this->assertEquals('user_profiles', $userProfile->getTable());
    }

    /**
     * Test UserProfiles guarded attributes.
     */
    public function test_user_profiles_guarded_attributes(): void
    {
        $userProfile = new UserProfiles();
        $expected = ['id'];

        $this->assertEquals($expected, $userProfile->getGuarded());
    }

    /**
     * Test user relationship.
     */
    public function test_user_relationship(): void
    {
        $userProfile = new UserProfiles();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $userProfile->user());
    }

    /**
     * Test UserProfiles uses required traits.
     */
    public function test_user_profiles_uses_traits(): void
    {
        $traits = class_uses(UserProfiles::class);

        $this->assertContains(\Backpack\CRUD\app\Models\Traits\CrudTrait::class, $traits);
        $this->assertContains(\Illuminate\Database\Eloquent\Factories\HasFactory::class, $traits);
    }

    /**
     * Test mass assignment protection.
     */
    public function test_mass_assignment_protection(): void
    {
        $userProfile = new UserProfiles();

        // Test common profile fields (assuming these are fillable)
        $profileData = [
            'user_id' => 1,
            'phone' => '0123456789',
            'address' => '123 Test Street',
            'date_of_birth' => '1990-01-01',
            'student_id' => 'ST123456',
        ];

        $userProfile->fill($profileData);

        // Should not be able to fill id (guarded)
        $userProfile->fill(['id' => 999]);
        $this->assertNull($userProfile->id);
    }

    /**
     * Test profile data validation scenarios.
     */
    public function test_profile_data_validation(): void
    {
        $userProfile = new UserProfiles();

        // Test phone number format (if applicable)
        $userProfile->fill(['phone' => '0123456789']);
        $this->assertEquals('0123456789', $userProfile->phone);

        // Test date of birth format
        $userProfile->fill(['date_of_birth' => '1990-01-01']);
        $this->assertEquals('1990-01-01', $userProfile->date_of_birth);
    }

    /**
     * Test UserProfiles model exists.
     */
    public function test_user_profiles_model_exists(): void
    {
        $this->assertTrue(class_exists(UserProfiles::class));
    }
}
