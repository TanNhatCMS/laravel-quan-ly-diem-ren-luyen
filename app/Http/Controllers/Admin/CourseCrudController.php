<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AcademicYearsRequest;
use App\Models\Course;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AcademicYearsCrudController.
 *
 * @property-read CrudPanel $crud
 */
class CourseCrudController extends CrudController
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
        CRUD::setModel(Course::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/course');
        CRUD::setEntityNameStrings('Niên Khoá', 'Danh Sách Niên Khoá');
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
            'label' => 'Tên Khoá',
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'year',
            'label' => 'Niên Khoá',
            'type' => 'text',
            'value' => function ($entry) {
                return $entry->year_start . ' - ' . $entry->year_end;
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
        CRUD::setValidation(AcademicYearsRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Tên Khoá',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'year_start',
            'label' => 'Năm Bắt Đầu',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'year_end',
            'label' => 'Năm Kết Thúc',
            'type' => 'text',
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
