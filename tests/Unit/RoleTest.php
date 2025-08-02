<?php

namespace Tests\Unit;

use App\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * Test Role model instantiation.
     */
    public function test_role_model_instantiation(): void
    {
        $role = new Role();
        $this->assertInstanceOf(Role::class, $role);
    }

    /**
     * Test Role extends original Role.
     */
    public function test_role_extends_original(): void
    {
        $role = new Role();
        $this->assertInstanceOf(\Spatie\Permission\Models\Role::class, $role);
    }

    /**
     * Test Role fillable attributes.
     */
    public function test_role_fillable_attributes(): void
    {
        $role = new Role();
        $expected = ['name', 'guard_name', 'updated_at', 'created_at'];
        
        $this->assertEquals($expected, $role->getFillable());
    }

    /**
     * Test Role uses CrudTrait.
     */
    public function test_role_uses_crud_trait(): void
    {
        $traits = class_uses(Role::class);
        $this->assertContains(\Backpack\CRUD\app\Models\Traits\CrudTrait::class, $traits);
    }
}