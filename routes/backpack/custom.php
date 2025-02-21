<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    // Allow demo users to switch between available themes and layouts
    Route::post('switch-layout', function (Request $request) {
        $theme = 'backpack.theme-' . $request->get('theme', 'tabler') . '::';
        Session::put('backpack.ui.view_namespace', $theme);

        if ($theme === 'backpack.theme-tabler::') {
            Session::put('backpack.theme-tabler.layout', $request->get('layout', 'horizontal'));
        }

        return Redirect::back();
    })->name('tabler.switch.layout');
    // ---------------------------
    // Backpack DEMO Custom Routes
    // Prevent people from doing nasty stuff in the online demo
    // ---------------------------
    if (app('env') == 'production') {
        // disable delete and bulk delete for all CRUDs
        $cruds = [
            'organizations',
            'majors',
            'classes',
            'course',
            'students',
            'teachers',
            'academic-degrees',
            'positions',
            'user',
            'role',
            'permission',
            'user-position',
            'user-organizations',
            'user-classes',
            'user-profiles',
            'faculty',
            'department',
            'evaluation-scores',
            'semester-scores',
            'notifications',
            'notification-statuses',
        ];
        foreach ($cruds as $name) {
            Route::delete($name . '/{id}', function () {
                return false;
            });
            Route::post($name . '/bulk-delete', function () {
                return false;
            });
        }
    }


    Route::crud('organizations', 'OrganizationsCrudController');
    Route::crud('majors', 'MajorsCrudController');
    Route::crud('classes', 'ClassesCrudController');
    Route::crud('course', 'CourseCrudController');
    Route::crud('students', 'StudentsCrudController');
    Route::crud('teachers', 'TeachersCrudController');
    Route::crud('academic-degrees', 'AcademicDegreesCrudController');
    Route::crud('positions', 'PositionsCrudController');
    Route::crud('user-position', 'UserPositionCrudController');
    Route::crud('user-organizations', 'UserOrganizationsCrudController');
    Route::crud('user-classes', 'UserClassesCrudController');
    Route::crud('user-profiles', 'UserProfilesCrudController');
    Route::crud('faculty', 'FacultyCrudController');
    Route::crud('department', 'DepartmentCrudController');
    Route::crud('evaluation-scores', 'EvaluationScoresCrudController');
    Route::crud('semester-scores', 'SemesterScoresCrudController');
    Route::crud('notifications', 'NotificationsCrudController');
    Route::crud('notification-statuses', 'NotificationStatusesCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
