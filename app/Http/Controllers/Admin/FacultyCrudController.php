<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FacultyRequest;
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
 * Class FacultyCrudController.
 *
 * @property-read CrudPanel $crud
 */
class FacultyCrudController extends CrudController
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
        CRUD::setModel(Organizations::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/faculty');
        CRUD::setEntityNameStrings('Khoa', 'Danh Sách Khoa');
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
        $this->crud->query->where('type', 'faculty');

        $this->crud->addColumn([
            'name' => 'stt',
            'label' => 'STT',
            'type' => 'row_number',
            'orderable' => false,
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Tên Khoa',
            'type' => 'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->where('name', 'like', '%'.$searchTerm.'%');
            },
        ]);
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
        CRUD::setValidation(FacultyRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Tên Khoa',
            'placeholder' => 'Nhập tên khoa',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'type',
            'type' => 'hidden',
            'value' => 'faculty',
        ]);
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
