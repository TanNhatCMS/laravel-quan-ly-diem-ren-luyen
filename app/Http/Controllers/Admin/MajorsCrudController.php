<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MajorsRequest;
use App\Models\Majors;
use App\Models\Organizations;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MajorsCrudController.
 *
 * @property-read CrudPanel $crud
 */
class MajorsCrudController extends CrudController
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
        CRUD::setModel(Majors::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/majors');
        CRUD::setEntityNameStrings('Chuyên Nghành', 'Danh Sách Chuyên Nghành');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Tên Chuyên Nghành',
            'type' => 'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->where('name', 'like', '%'.$searchTerm.'%');
            },
        ]);
        $this->crud->addColumn([
            'name' => 'code',
            'label' => 'Mã Chuyên Nghành',
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'organization_id',
            'label' => 'Khoa',
            'type' => 'select',
            'entity' => 'organization',
            'attribute' => 'name',
            'model' => Organizations::class,
            //thêm link
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('organizations/'.$related_key.'/show');
                },
            ],
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
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MajorsRequest::class);
        $this->crud->addField([
            'name' => 'code',
            'label' => 'Mã Chuyên Nghành',
            'type' => 'text',
            'allows_null' => true,
        ]);
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Tên Chuyên Nghành',
            'type' => 'text',
            'allows_null' => false,
        ]);
        $this->crud->addField([
            'name' => 'organization_id',
            'label' => 'Khoa',
            'type' => 'select_from_array',
            'options' => Organizations::where('type', '=', 'faculty')->pluck('name', 'id')->toArray(),
            'allows_null' => false,
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
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
