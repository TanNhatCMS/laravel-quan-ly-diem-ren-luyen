<?php

namespace Tests\Unit;

use App\Models\Classes;
use App\Models\Organizations;
use App\Models\Majors;
use App\Models\Course;
use App\Models\UserClasses;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test classes model instantiation.
     */
    public function test_classes_model_instantiation(): void
    {
        $class = new Classes();
        $this->assertInstanceOf(Classes::class, $class);
    }

    /**
     * Test classes fillable attributes.
     */
    public function test_classes_fillable_attributes(): void
    {
        $class = new Classes();
        $expected = ['name', 'organization_id', 'major_id', 'course_id'];
        
        $this->assertEquals($expected, $class->getFillable());
    }

    /**
     * Test classes table name.
     */
    public function test_classes_table_name(): void
    {
        $class = new Classes();
        $this->assertEquals('classes', $class->getTable());
    }

    /**
     * Test organization relationship.
     */
    public function test_organization_relationship(): void
    {
        $class = new Classes();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $class->organization());
    }

    /**
     * Test major relationship.
     */
    public function test_major_relationship(): void
    {
        $class = new Classes();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $class->major());
    }

    /**
     * Test course relationship.
     */
    public function test_course_relationship(): void
    {
        $class = new Classes();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $class->course());
    }

    /**
     * Test userClasses relationship.
     */
    public function test_user_classes_relationship(): void
    {
        $class = new Classes();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $class->userClasses());
    }

    /**
     * Test users relationship.
     */
    public function test_users_relationship(): void
    {
        $class = new Classes();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $class->users());
    }
}