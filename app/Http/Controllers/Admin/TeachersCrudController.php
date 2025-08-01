<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserGender;
use App\Http\Controllers\Admin\Traits\UserCrudTrait;
use App\Http\Requests\LecturersRequest;
use App\Models\AcademicDegrees;
use App\Models\Classes;
use App\Models\Organizations;
use App\Models\Positions;
use App\Models\User;
use App\Models\UserPosition;
use App\Models\UserProfiles;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;

/**
 * Class TeachersCrudController.
 *
 * @property-read CrudPanel $crud
 */
class TeachersCrudController extends CrudController
{
    use CreateOperation {
        store as traitStore;
    }
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation {
        update as traitUpdate;
    }
    use UserCrudTrait;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     *
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/teachers');
        CRUD::setEntityNameStrings('Giáo Viên', 'Danh Sách Giáo Viên');
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
            $query->Where('type', 'teacher');
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
            'name' => 'profile.academicDegree',
            'label' => 'Trình độ chuyên môn',
            'type' => 'select',
            'entity' => 'profile.academicDegree',
            'attribute' => 'name',
            'model' => AcademicDegrees::class,
        ]);

        $this->crud->addColumn([
            'name' => 'organizations',
            'label' => 'Phòng ban/Khoa',
            'type' => 'select_multiple',
            'entity' => 'organizations',
            'attribute' => 'name',
            'model' => Organizations::class,
        ]);

        $this->crud->addColumn([
            'name' => 'profile.phone_number',
            'label' => 'Số điện thoại',
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'profile.birth_date',
            'label' => 'Ngày sinh',
            'entity' => 'profile',
            'model' => UserProfiles::class,
            'attribute' => 'birth_date',
            'type' => 'date',
        ]);

        $this->crud->addColumn([
            'name' => 'positions',
            'label' => 'Chức vụ',
            'entity' => 'positions',
            'attribute' => 'name',
            'model' => UserPosition::class,
            'type' => 'select_multiple',
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
        $this->addUserFields();
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

    /**
     * Store a newly created resource in the database.
     */
    public function store()
    {
        return $this->storeUserEntity();
    }

    /**
     * Update the specified resource in the database.
     */
    public function update()
    {
        return $this->updateUserEntity();
    }

    private function addUserFields()
    {
        $fields = [
            [
                'name' => 'name',
                'label' => 'Tên',
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email',
            ],
            [
                'name' => 'profile.phone_number',
                'label' => 'Số điện thoại',
                'entity' => 'profile.phone_number',
                'type' => 'text',
            ],
        ];

        // Add password fields from trait
        $fields = array_merge($fields, $this->getPasswordFields());

        $fields = array_merge($fields, [
            [
                'name' => 'profile.birth_date',
                'label' => 'Ngày sinh',
                'entity' => 'profile.birth_date',
                'type' => 'date',
            ],
            [
                'name' => 'profile.gender',
                'label' => 'Giới tính',
                'type' => 'select_from_array',
                'options' => collect(UserGender::cases())->mapWithKeys(fn ($g) => [$g->value => $g->toVN()])->toArray(),
                'allows_null' => false,
                'default' => UserGender::OTHER->value,
            ],
            [
                'name' => 'profile.academicDegree',
                'label' => 'Trình độ chuyên môn',
                'type' => 'select',
                'entity' => 'profile.academicDegree',
                'attribute' => 'name',
                'model' => AcademicDegrees::class,
            ],
            [
                'name' => 'organizations',
                'label' => 'Phòng ban/Khoa',
                'type' => 'checklist',
                'entity' => 'organizations',
                'attribute' => 'name',
                'model' => Organizations::class,
            ],
            [
                'name' => 'positions',
                'label' => 'Chức vụ',
                'type' => 'checklist',
                'entity' => 'positions',
                'attribute' => 'name',
                'model' => Positions::class,
            ],
            [
                'name' => 'class',
                'label' => 'Quản Lý Lớp',
                'type' => 'checklist',
                'attribute' => 'name',
                'entity' => 'class',
                'model' => Classes::class,
            ],
        ]);

        // Add permission fields from trait
        $fields = array_merge($fields, $this->getUserPermissionFields());

        $fields[] = [
            'name' => 'profile.type',
            'type' => 'hidden',
            'value' => 'teacher',
            'entity' => 'profile.type',
        ];

        $this->crud->addFields($fields);
    }
}
