<?php

namespace Tests\Unit;

use App\Models\Majors;
use App\Models\Organizations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MajorsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Majors model instantiation.
     */
    public function test_majors_model_instantiation(): void
    {
        $major = new Majors();
        $this->assertInstanceOf(Majors::class, $major);
    }

    /**
     * Test Majors table name.
     */
    public function test_majors_table_name(): void
    {
        $major = new Majors();
        $this->assertEquals('majors', $major->getTable());
    }

    /**
     * Test Majors guarded attributes.
     */
    public function test_majors_guarded_attributes(): void
    {
        $major = new Majors();
        $expected = ['id'];

        $this->assertEquals($expected, $major->getGuarded());
    }

    /**
     * Test organization relationship.
     */
    public function test_organization_relationship(): void
    {
        $major = new Majors();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $major->organization());
    }

    /**
     * Test classes relationship.
     */
    public function test_classes_relationship(): void
    {
        $major = new Majors();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $major->classes());
    }

    /**
     * Test Majors uses required traits.
     */
    public function test_majors_uses_traits(): void
    {
        $traits = class_uses(Majors::class);

        $this->assertContains(\Backpack\CRUD\app\Models\Traits\CrudTrait::class, $traits);
        $this->assertContains(\Illuminate\Database\Eloquent\Factories\HasFactory::class, $traits);
    }

    /**
     * Test mass assignment protection.
     */
    public function test_mass_assignment_protection(): void
    {
        $major = new Majors();
        
        // Test fillable attributes (assuming name is fillable)
        $major->fill(['name' => 'Computer Science']);
        $this->assertEquals('Computer Science', $major->name);
        
        // Should not be able to fill id (guarded)
        $major->fill(['id' => 999]);
        $this->assertNull($major->id);
    }
}