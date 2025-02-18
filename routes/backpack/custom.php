<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.
Route::group([
    'namespace' => 'App\Http\Controllers\Admin\PermissionManager',
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::crud('permission', 'PermissionCrudController');
    Route::crud('role', 'RoleCrudController');
    Route::crud('user', 'UserCrudController');
});

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('organizations', 'OrganizationsCrudController');
    Route::crud('majors', 'MajorsCrudController');
    Route::crud('classes', 'ClassesCrudController');
    Route::crud('academic-years', 'AcademicYearsCrudController');
    Route::crud('students', 'StudentsCrudController');
    Route::crud('teachers', 'TeachersCrudController');
    Route::crud('academic-degrees', 'AcademicDegreesCrudController');
    Route::crud('positions', 'PositionsCrudController');
    Route::crud('user-position', 'UserPositionCrudController');
    Route::crud('user-organizations', 'UserOrganizationsCrudController');
    Route::crud('user-classes', 'UserClassesCrudController');
    Route::crud('user-profiles', 'UserProfilesCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
