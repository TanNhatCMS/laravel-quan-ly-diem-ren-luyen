<?php

namespace Tests\Unit;

use App\Models\Positions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Positions model instantiation.
     */
    public function test_positions_model_instantiation(): void
    {
        $position = new Positions();
        $this->assertInstanceOf(Positions::class, $position);
    }

    /**
     * Test Positions table name.
     */
    public function test_positions_table_name(): void
    {
        $position = new Positions();
        $this->assertEquals('positions', $position->getTable());
    }

    /**
     * Test Positions guarded attributes.
     */
    public function test_positions_guarded_attributes(): void
    {
        $position = new Positions();
        $expected = ['id'];

        $this->assertEquals($expected, $position->getGuarded());
    }

    /**
     * Test Positions uses required traits.
     */
    public function test_positions_uses_traits(): void
    {
        $traits = class_uses(Positions::class);

        $this->assertContains(\Backpack\CRUD\app\Models\Traits\CrudTrait::class, $traits);
        $this->assertContains(\Illuminate\Database\Eloquent\Factories\HasFactory::class, $traits);
    }

    /**
     * Test Positions model exists.
     */
    public function test_positions_model_exists(): void
    {
        $this->assertTrue(class_exists(Positions::class));
    }
}
