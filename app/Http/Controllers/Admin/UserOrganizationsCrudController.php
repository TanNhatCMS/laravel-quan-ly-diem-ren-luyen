<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserOrganizationsRequest;
use App\Models\Organizations;
use App\Models\Positions;
use App\Models\User;
use App\Models\UserOrganizations;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserOrganizationsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UserOrganizationsCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(UserOrganizations::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-organizations');
        CRUD::setEntityNameStrings('Người Dùng - Tổ Chức', 'Danh Sách Người Dùng - Tổ Chức');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'stt',
            'label' => 'STT',
            'type' => 'row_number',
            'orderable' => false,
        ]);
        CRUD::addColumn([
            'name' => 'user',
            'label' => 'Người dùng',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => "App\Models\User",
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('user', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', "%$searchTerm%");
                });
            }
        ]);
        CRUD::addColumn([
            'name' => 'email',
            'label' => 'Email',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'email',
            'model' => "App\Models\User",
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('user', function ($q) use ($searchTerm) {
                    $q->where('email', 'like', "%$searchTerm%");
                });
            }
        ]);
        CRUD::addColumn([
            'name' => 'organization',
            'label' => 'Tổ chức',
            'type' => 'select',
            'entity' => 'organization',
            'attribute' => 'name',
            'model' => "App\Models\Organizations",
        ]);

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserOrganizationsRequest::class);
        $this->crud->addField([
            'name' => 'user',
            'label' => 'Người dùng',
            'type' => 'select_from_array',
            'options' => User::all()->pluck('email', 'id')->toArray(),
        ]);
        CRUD::addField([
            'name' => 'organization',
            'label' => 'Tổ chức',
            'type' => 'select_from_array',
            'entity' => 'organization',
            'attribute' => 'name',
            'options' => Organizations::all()->pluck('name', 'id')->toArray(),
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
