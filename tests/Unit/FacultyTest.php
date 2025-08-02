<?php

namespace Tests\Unit;

use App\Models\Faculty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacultyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test faculty model instantiation.
     */
    public function test_faculty_model_instantiation(): void
    {
        $faculty = new Faculty();
        $this->assertInstanceOf(Faculty::class, $faculty);
    }

    /**
     * Test faculty table name.
     */
    public function test_faculty_table_name(): void
    {
        $faculty = new Faculty();
        $this->assertEquals('faculties', $faculty->getTable());
    }

    /**
     * Test faculty guarded attributes.
     */
    public function test_faculty_guarded_attributes(): void
    {
        $faculty = new Faculty();
        $expected = ['id'];
        
        $this->assertEquals($expected, $faculty->getGuarded());
    }

    /**
     * Test faculty model exists.
     */
    public function test_faculty_model_exists(): void
    {
        $this->assertTrue(class_exists(Faculty::class));
    }
}