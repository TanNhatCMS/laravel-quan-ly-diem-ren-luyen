<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrganizationsRequest;
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
 * Class OrganizationsCrudController.
 *
 * @property-read CrudPanel $crud
 */
class OrganizationsCrudController extends CrudController
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
        CRUD::setRoute(config('backpack.base.route_prefix').'/organizations');
        CRUD::setEntityNameStrings('Phòng/Khoa', 'Tổ Chức');
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
            'label' => 'Tên Tổ Chức',
            'type' => 'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->where('name', 'like', '%'.$searchTerm.'%');
            },
        ]);
        $this->crud->addColumn([
            'name' => 'type',
            'label' => 'Loại Tổ Chức',
            'type' => 'text',
            'wrapper' => [
                'element' => 'span',
                'class' => function ($crud, $column, $entry) {
                    return $entry->type == 'department' ? 'badge bg-success' : 'badge bg-info';
                },
            ],
            'value' => function ($entry) {
                $translations = [
                    'department' => 'Phòng',
                    'faculty' => 'Khoa',
                ];

                return $translations[$entry->type] ?? $entry->type; // Trả về giá trị gốc nếu không có bản dịch
            },
        ]);

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'type',
            'label' => 'Loại Tổ Chức',
        ],
            [
                'department' => 'Phòng',
                'faculty' => 'Khoa',
            ], function ($value) {
                $map = [
                    '1' => 'department',
                    '2' => 'faculty',
                    'department' => 'department',
                    'faculty' => 'faculty',
                ];
                $this->crud->addClause('where', 'type', $map[$value]);
            },
        );
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
        CRUD::setValidation(OrganizationsRequest::class);
        $this->crud->addField(
            [
                'name' => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'text',
            ]
        );
        $this->crud->addField([
            'name' => 'type',
            'label' => 'Loại Tổ Chức',
            'type' => 'select_from_array',
            'options' => [
                'department' => 'Phòng',
                'faculty' => 'Khoa',
            ],
            'allows_null' => false,
            'default' => 'department',
        ]);
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
