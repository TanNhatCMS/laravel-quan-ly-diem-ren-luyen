<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClassesRequest;
use App\Models\Classes;
use App\Models\Course;
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
 * Class ClassesCrudController.
 *
 * @property-read CrudPanel $crud
 */
class ClassesCrudController extends CrudController
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
        CRUD::setModel(Classes::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/classes');
        CRUD::setEntityNameStrings('Lớp', 'Danh Sách Lớp');
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
            'name' => 'stt',
            'label' => 'STT',
            'type' => 'row_number',
            'orderable' => false,
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Tên Lớp',
            'type' => 'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->where('name', 'like', '%'.$searchTerm.'%');
            },
        ]);
        $this->crud->addColumn([
            'name' => 'course',
            'label' => 'Khóa',
            'type' => 'select',
            'entity' => 'course',
            'attribute' => 'name',
        ]);

        $this->crud->addColumn([
            'name' => 'course_year',
            'label' => 'Niên Khóa',
            'type' => 'text',
            'entity' => 'course',
            'value' => function ($entry) {
                return $entry->course->year_start.' - '.$entry->course->year_end;
            },
        ]);

        $this->crud->addColumn([
            'name' => 'major',
            'label' => 'Chuyên Ngành',
            'type' => 'select',
            'entity' => 'major',
            'attribute' => 'name',
        ]);
        $this->crud->addColumn([
            'name' => 'organization',
            'label' => 'Khoa',
            'type' => 'select',
            'entity' => 'organization',
            'attribute' => 'name',
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
        CRUD::setValidation(ClassesRequest::class);

        $this->crud->addField([
            'name' => 'organization',
            'label' => 'Khoa',
            'type' => 'select_from_array',
            'options' => Organizations::where('type', '=', 'faculty')->pluck('name', 'id')->toArray(),
        ]);

        $this->crud->addField([
            'name' => 'major',
            'label' => 'Chuyên Ngành',
            'type' => 'select_from_array',
            'options' => Majors::all()->pluck('name', 'id')->toArray(),
        ]);

        $this->crud->addField([
            'name' => 'course',
            'label' => 'Niên Khóa',
            'type' => 'select_from_array',
            'options' => Course::all()->pluck('name', 'id')->toArray(),
        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Tên lớp',
            'type' => 'text',
            'placeholder' => 'Nhập tên lớp',
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
