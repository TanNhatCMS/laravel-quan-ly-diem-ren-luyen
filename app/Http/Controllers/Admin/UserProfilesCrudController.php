<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserProfilesRequest;
use App\Models\AcademicDegrees;
use App\Models\User;
use App\Models\UserClasses;
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
 * Class UserProfilesCrudController.
 *
 * @property-read CrudPanel $crud
 */
class UserProfilesCrudController extends CrudController
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
        CRUD::setRoute(config('backpack.base.route_prefix').'/user-profiles');
        CRUD::setEntityNameStrings('Hồ sơ', 'Hồ sơ người dùng');
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

        CRUD::addColumn([
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

//        $this->crud->addColumn([
//            'name' => 'class_id',
//            'label' => 'Lớp',
//            'type' => 'select',
//            'entity' => 'profile',
//            'attribute' => 'name',
//            'model' => UserProfiles::class,
//        ]);

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
        $this->crud->setValidation(UserProfilesRequest::class);
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
        $this->crud->setValidation(UserProfilesRequest::class);
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

    private function saveRelatedModels(UserProfiles $profile)
    {
        $userId = $profile->user_id;
        $classId = request()->input('class_id');
        $organizationId = request()->input('organization_id');
        $positionId = request()->input('position_id');

        // Cập nhật UserClasses
        if ($classId) {
            UserClasses::updateOrCreate(
                ['user_id' => $userId, 'class_id' => $classId]
            );
        }

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
                'name' => 'phone_number',
                'label' => 'Số điện thoại',
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
                'options' => ['Nam' => 'Nam', 'Nữ' => 'Nữ', 'Khác' => 'Khác'],
            ],
            [
                // two interconnected entities
                'label' => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type' => 'checklist_dependency',
                'name' => 'roles,permissions',
                'subfields' => [
                    'primary' => [
                        'label' => trans('backpack::permissionmanager.roles'),
                        'name' => 'roles', // the method that defines the relationship in your Model
                        'entity' => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute' => 'name', // foreign key attribute that is shown to user
                        'model' => config('permission.models.role'), // foreign key model
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label' => mb_ucfirst(trans('backpack::permissionmanager.permission_plural')),
                        'name' => 'permissions', // the method that defines the relationship in your Model
                        'entity' => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute' => 'name', // foreign key attribute that is shown to user
                        'model' => config('permission.models.permission'), // foreign key model
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],
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
