<?php

namespace Tests\Unit;

use App\Models\Permission;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    /**
     * Test Permission model instantiation.
     */
    public function test_permission_model_instantiation(): void
    {
        $permission = new Permission();
        $this->assertInstanceOf(Permission::class, $permission);
    }

    /**
     * Test Permission extends original Permission.
     */
    public function test_permission_extends_original(): void
    {
        $permission = new Permission();
        $this->assertInstanceOf(\Spatie\Permission\Models\Permission::class, $permission);
    }

    /**
     * Test Permission fillable attributes.
     */
    public function test_permission_fillable_attributes(): void
    {
        $permission = new Permission();
        $expected = ['name', 'guard_name', 'updated_at', 'created_at'];
        
        $this->assertEquals($expected, $permission->getFillable());
    }

    /**
     * Test Permission uses CrudTrait.
     */
    public function test_permission_uses_crud_trait(): void
    {
        $traits = class_uses(Permission::class);
        $this->assertContains(\Backpack\CRUD\app\Models\Traits\CrudTrait::class, $traits);
    }
}