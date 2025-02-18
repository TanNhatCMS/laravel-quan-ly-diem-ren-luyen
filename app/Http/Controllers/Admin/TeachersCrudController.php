<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LecturersRequest;
use App\Models\User;
use App\Models\UserPosition;
use App\Models\UserProfiles;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LecturersCrudController.
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TeachersCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
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
        $this->crud->setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/lecturers');
        CRUD::setEntityNameStrings('lecturers', 'lecturers');
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

        $this->crud->query->whereHas('profile', function ($query) {
            $query->whereNull('code')->orWhere('code', '');
        });

        $this->crud->addColumn([
            'name' => 'stt',
            'label' => 'STT',
            'type' => 'row_number',
            'orderable' => false,
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Tên',
            'type' => 'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->where('name', 'like', '%'.$searchTerm.'%');
            },
        ]);

        $this->crud->addColumn([
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->where('email', 'like', '%'.$searchTerm.'%');
            },
        ]);

        $this->crud->addColumn([
            'name' => 'code',
            'label' => 'Mã Số Sinh Viên',
            'type' => 'text',
            'entity' => 'profile',
            'model' => UserProfiles::class,
            'attribute' => 'code',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->where('code', 'like', '%'.$searchTerm.'%');
            },
        ]);

        $this->crud->addColumn([
            'name' => 'class_id',
            'label' => 'Lớp',
            'type' => 'select',
            'entity' => 'profile',
            'attribute' => 'name',
            'model' => UserProfiles::class,
        ]);

//        $this->crud->addColumn([
//            'name' => 'academic_degree_id',
//            'label' => 'Trình độ chuyên môn',
//            'type' => 'select',
//            'entity' => 'academicDegree',
//            'attribute' => 'name',
//            'model' => AcademicDegrees::class,
//        ]);
//
        $this->crud->addColumn([
            'name' => 'organizations',
            'label' => 'Phòng ban/Khoa',
            'type' => 'select_multiple',
            'entity' => 'organizations',
            'attribute' => 'name',
            'model' => UserPosition::class,
        ]);

        $this->crud->addColumn([
            'name' => 'positions',
            'label' => 'Chức vụ',
            'entity' => 'positions',
            'attribute' => 'name',
            'model' => UserPosition::class,
            'type' => 'select_multiple',
        ]);

        $this->crud->addColumn([
            'name' => 'phone_number',
            'label' => 'Số điện thoại',
            'entity' => 'profile',
            'model' => UserProfiles::class,
            'attribute' => 'code',
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'birth_date',
            'label' => 'Ngày sinh',
            'entity' => 'profile',
            'model' => UserProfiles::class,
            'attribute' => 'code',
            'type' => 'date',
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
        CRUD::setValidation(LecturersRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

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
