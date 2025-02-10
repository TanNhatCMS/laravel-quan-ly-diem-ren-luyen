<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('departments', 'DepartmentsCrudController');
    Route::crud('classes', 'ClassesCrudController');
    Route::crud('students', 'StudentsCrudController');
    Route::crud('lecturers', 'LecturersCrudController');
    Route::crud('semester-scores', 'SemesterScoresCrudController');
    Route::crud('class-officers', 'ClassOfficersCrudController');
    Route::crud('organizations', 'OrganizationsCrudController');
    Route::crud('majors', 'MajorsCrudController');
}); // this should be the absolute last line of this file
Route::group([
    'namespace'  => 'App\Http\Controllers\Admin\PermissionManager',
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::crud('permission', 'PermissionCrudController');
    Route::crud('role', 'RoleCrudController');
    Route::crud('user', 'UserCrudController');
});
/**
 * DO NOT ADD ANYTHING HERE.
 */
