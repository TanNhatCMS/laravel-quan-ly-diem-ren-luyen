<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SemesterScoresRequest;
use App\Models\SemesterScores;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SemesterScoresCrudController.
 *
 * @property-read CrudPanel $crud
 */
class SemesterScoresCrudController extends CrudController
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
        CRUD::setModel(SemesterScores::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/semester-scores');
        CRUD::setEntityNameStrings('Học kỳ', 'Điểm rèn luyện học kỳ');
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

        CRUD::addColumns([
            [
                'name' => 'year',
                'label' => 'Năm học',
                'type' => 'text',
            ],
            [
                'name' => 'semester',
                'label' => 'Học kỳ',
                'type' => 'select_from_array',
                'options' => [
                    '1' => 'Học Kỳ 1',
                    '2' => 'Học Kỳ 2',
                    '3' => 'Học Kỳ 3',
                ],
            ],
            [
                'name' => 'evaluation_start',
                'label' => 'Ngày bắt đầu',
                'type' => 'date',
            ],
            [
                'name' => 'evaluation_end',
                'label' => 'Ngày kết thúc',
                'type' => 'date',
            ],
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
        CRUD::setValidation(SemesterScoresRequest::class);

        CRUD::addFields([
            [
                'name' => 'year',
                'label' => 'Năm học',
                'type' => 'text',
            ],
            [
                'name' => 'semester',
                'label' => 'Học kỳ',
                'type' => 'select_from_array',
                'options' => [
                    '1' => 'Học Kỳ 1',
                    '2' => 'Học Kỳ 2',
                    '3' => 'Học Kỳ 3',
                ],
            ],
            [
                'name' => 'evaluation_start',
                'label' => 'Ngày bắt đầu',
                'type' => 'date',
            ],
            [
                'name' => 'evaluation_end',
                'label' => 'Ngày kết thúc',
                'type' => 'date',
            ],
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
