<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserGender;
use App\Http\Requests\Student\StudentStoreCrudRequest;
use App\Http\Requests\Student\StudentUpdateCrudRequest;
use App\Models\User;
use App\Models\UserOrganizations;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class StudentsCrudController.
 *
 * @property-read CrudPanel $crud
 */
class StudentsCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation { store as traitStore; }
    use UpdateOperation { update as traitUpdate; }
    use DeleteOperation;
    use ShowOperation;

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
        CRUD::setRoute(config('backpack.base.route_prefix').'/students');
        CRUD::setEntityNameStrings('Sinh Viên', 'Danh Sách Sinh Viên');
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
            $query->where('type', 'student');
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
        $this->addUserFields();
        $this->crud->setValidation(StudentStoreCrudRequest::class);
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
        $this->addUserFields();
        $this->crud->setValidation(StudentUpdateCrudRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation();
        $response = $this->traitStore();
        $this->saveRelatedModels($this->crud->entry);

        return $response;
    }

    /**
     * Update the specified resource in the database.
     *
     * @return RedirectResponse
     */
    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation();
        $response = $this->traitUpdate();
        $this->saveRelatedModels($this->crud->entry);

        return $response;
    }

    private function saveRelatedModels(User $user)
    {
        $userId = $user->id;
        $classId = request()->input('class_id');
        $organizationId = request()->input('organization_id');
        $positionId = request()->input('position_id');
        UserProfiles::updateOrCreate(
            ['user_id' => $userId],
            [
                'code' => request()->input('code'),
                'academic_degree_id' => request()->input('academic_degree_id'),
                'education_system' => request()->input('education_system'),
                'type' => 'student',
            ]
        );

        // Cập nhật UserOrganizations
        if ($organizationId) {
            UserOrganizations::updateOrCreate(
                ['user_id' => $userId, 'organization_id' => $organizationId]
            );
        }

        // Cập nhật UserPosition
        if ($positionId) {
            UserPosition::updateOrCreate(
                ['user_id' => $userId, 'position_id' => $positionId]
            );
        }
    }

    private function addUserFields()
    {
        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Tên',
                'type' => 'text',
            ],
            [
                'name' => 'code',
                'label' => 'Mã Số Sinh Viên',
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
            [
                'name' => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type' => 'password',
            ],
            [
                'name' => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type' => 'password',
            ],
            [
                'name' => 'birth_date',
                'label' => 'Ngày sinh',
                'type' => 'date',
            ],
            [
                'name' => 'gender',
                'label' => 'Giới tính',
                'type' => 'select_from_array',
                'options' => UserGender::cases(),
                'allows_null' => false,
                'default' => UserGender::OTHER,
            ],
            ['name' => 'class_id',
                'label' => 'Lớp',
                'type' => 'select',
                'entity' => 'profile.class_id',
                'attribute' => 'name',
                'model' => "App\Models\Classes",
            ],
            //            [
            //                'name' => 'academic_degree_id',
            //                'label' => 'Trình độ chuyên môn',
            //                'type' => 'select',
            //                'entity' => 'academicDegree',
            //                'attribute' => 'name',
            //                'model' => "App\Models\AcademicDegrees",
            //            ],
            //            [
            //                'name' => 'education_system',
            //                'label' => 'Hệ đào tạo',
            //                'type' => 'select_from_array',
            //                'options' => [
            //                    '0' => 'Chính quy',
            //                    '1' => 'Văn bằng 2',
            //                    '2' => 'Văn bằng 3',
            //                    '3' => 'Liên thông',
            //                    '4' => 'Cao học',
            //                ],
            //                'allows_null' => false,
            //                'default' => '0',
            //            ],

        ]);
    }

    /**
     * Handle password input fields.
     */
    private function handlePasswordInput(Request $request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }
}
