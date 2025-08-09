<?php

namespace Tests\Unit;

use App\Models\Classes;
use App\Models\Majors;
use App\Models\Organizations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Organizations model instantiation.
     */
    public function test_organizations_model_instantiation(): void
    {
        $organization = new Organizations();
        $this->assertInstanceOf(Organizations::class, $organization);
    }

    /**
     * Test Organizations table name.
     */
    public function test_organizations_table_name(): void
    {
        $organization = new Organizations();
        $this->assertEquals('organizations', $organization->getTable());
    }

    /**
     * Test Organizations fillable attributes.
     */
    public function test_organizations_fillable_attributes(): void
    {
        $organization = new Organizations();
        $expected = ['name', 'type'];

        $this->assertEquals($expected, $organization->getFillable());
    }

    /**
     * Test Organizations guarded attributes.
     */
    public function test_organizations_guarded_attributes(): void
    {
        $organization = new Organizations();
        $expected = ['id'];

        $this->assertEquals($expected, $organization->getGuarded());
    }

    /**
     * Test users relationship.
     */
    public function test_users_relationship(): void
    {
        $organization = new Organizations();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $organization->users());
    }

    /**
     * Test majors relationship.
     */
    public function test_majors_relationship(): void
    {
        $organization = new Organizations();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $organization->majors());
    }

    /**
     * Test classes relationship.
     */
    public function test_classes_relationship(): void
    {
        $organization = new Organizations();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $organization->classes());
    }

    /**
     * Test Organizations uses required traits.
     */
    public function test_organizations_uses_traits(): void
    {
        $traits = class_uses(Organizations::class);

        $this->assertContains(\Backpack\CRUD\app\Models\Traits\CrudTrait::class, $traits);
        $this->assertContains(\Illuminate\Database\Eloquent\Factories\HasFactory::class, $traits);
    }

    /**
     * Test mass assignment protection.
     */
    public function test_mass_assignment_protection(): void
    {
        $organization = new Organizations();

        // Should be able to fill name and type
        $organization->fill(['name' => 'Test Org', 'type' => 'department']);
        $this->assertEquals('Test Org', $organization->name);
        $this->assertEquals('department', $organization->type);

        // Should not be able to fill id (guarded)
        $organization->fill(['id' => 999]);
        $this->assertNull($organization->id);
    }
}
