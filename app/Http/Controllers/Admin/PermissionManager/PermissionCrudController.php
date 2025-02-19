<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use App\Http\Requests\PermissionManager\PermissionStoreCrudRequest as StoreRequest;
use App\Http\Requests\PermissionManager\PermissionUpdateCrudRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Spatie\Permission\PermissionRegistrar;

// VALIDATION

class PermissionCrudController extends CrudController
{
    protected string $role_model;
    protected string $permission_model;

    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;

    /**
     * @throws Exception
     */
    public function setup()
    {
        $this->role_model = config('backpack.permissionmanager.models.role');
        $this->permission_model = $permission_model = config('backpack.permissionmanager.models.permission');

        $this->crud->setModel($permission_model);
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.permission_singular'), trans('backpack::permissionmanager.permission_plural'));
        $this->crud->setRoute(backpack_url('permission'));

        // deny access according to configuration file
        if (! config('backpack.permissionmanager.allow_permission_create')) {
            $this->crud->denyAccess('create');
        }
        if (! config('backpack.permissionmanager.allow_permission_update')) {
            $this->crud->denyAccess('update');
        }
        if (! config('backpack.permissionmanager.allow_permission_delete')) {
            $this->crud->denyAccess('delete');
        }
    }

    public function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type' => 'text',
        ]);

        if (config('backpack.permissionmanager.multiple_guards')) {
            $this->crud->addColumn([
                'name' => 'guard_name',
                'label' => trans('backpack::permissionmanager.guard_type'),
                'type' => 'text',
            ]);
        }
    }

    /**
     * @throws BindingResolutionException
     */
    public function setupCreateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(StoreRequest::class);

        //otherwise, changes won't have effect
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * @throws BindingResolutionException
     */
    public function setupUpdateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(UpdateRequest::class);

        //otherwise, changes won't have effect
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function addFields()
    {
        $this->crud->addField([
            'name' => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type' => 'text',
        ]);

        if (config('backpack.permissionmanager.multiple_guards')) {
            $this->crud->addField([
                'name' => 'guard_name',
                'label' => trans('backpack::permissionmanager.guard_type'),
                'type' => 'select_from_array',
                'options' => $this->getGuardTypes(),
            ]);
        }
    }

    /*
     * Get an array list of all available guard types
     * that have been defined in app/config/auth.php
     *
     * @return array
     **/
    private function getGuardTypes()
    {
        $guards = config('auth.guards');

        $returnable = [];
        foreach ($guards as $key => $details) {
            $returnable[$key] = $key;
        }

        return $returnable;
    }
}
