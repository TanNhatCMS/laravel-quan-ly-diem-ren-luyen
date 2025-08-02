<?php

namespace Tests\Unit;

use App\Models\Classes;
use App\Models\Course;
use Tests\TestCase;

class CourseTest extends TestCase
{
    /**
     * Test Course model instantiation.
     */
    public function test_course_model_instantiation(): void
    {
        $course = new Course();
        $this->assertInstanceOf(Course::class, $course);
    }

    /**
     * Test Course table name.
     */
    public function test_course_table_name(): void
    {
        $course = new Course();
        $this->assertEquals('courses', $course->getTable());
    }

    /**
     * Test Course fillable attributes.
     */
    public function test_course_fillable_attributes(): void
    {
        $course = new Course();
        $expected = ['name', 'year_start', 'year_end'];

        $this->assertEquals($expected, $course->getFillable());
    }

    /**
     * Test Course guarded attributes.
     */
    public function test_course_guarded_attributes(): void
    {
        $course = new Course();
        $expected = ['id'];

        $this->assertEquals($expected, $course->getGuarded());
    }

    /**
     * Test classes relationship.
     */
    public function test_classes_relationship(): void
    {
        $course = new Course();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $course->classes());
    }

    /**
     * Test Course uses required traits.
     */
    public function test_course_uses_traits(): void
    {
        $traits = class_uses(Course::class);

        $this->assertContains(\Backpack\CRUD\app\Models\Traits\CrudTrait::class, $traits);
        $this->assertContains(\Illuminate\Database\Eloquent\Factories\HasFactory::class, $traits);
    }
}
