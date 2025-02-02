<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClassesRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClassesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClassesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Classes::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/classes');
        CRUD::setEntityNameStrings('Lớp', 'Danh Sách Lớp');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // set columns from db columns.
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Lớp',
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'department_id',
            'label' => 'Khoa',
            'type' => 'select',
            'entity' => 'department',
            'attribute' => 'name',
            'visibleInTable' => true,
            'visibleInModal' => false,
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
        CRUD::setValidation(ClassesRequest::class);
       // CRUD::setFromDb(); // set fields from db columns.
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Tên lớp',
            'type' => 'text',
            'placeholder' => 'Nhập tên lớp',
        ]);

        $this->crud->addField([
            'name' => 'department_id ',
            'label' => 'Khoa',
            'type' => 'select_from_array',
            'options' => \App\Models\Departments::all()->pluck('name', 'id')->toArray(),
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
