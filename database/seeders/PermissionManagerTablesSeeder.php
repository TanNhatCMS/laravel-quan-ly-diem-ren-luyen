<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PermissionManagerTablesSeeder extends Seeder
{
    protected array $roles = [
        'SuperAdmin', // 1
        'Admin', // 2
        'StudentAffairsOffice', // 3. phòng công tác sinh viên
        'AcademicAdvisor', //4. cố vấn học tập
        'Lecturer', //5. giảng viên
        'ClassOfficer', //6. ban cán sự lớp
        'Student', // sinh viên
    ];

    protected array $permissionsRoles = [
        'manage news' => [1, 2],
        'manage pages' => [1, 2],
        'manage menu items' => [1, 2],
        'manage users' => [1, 2],
        'manage roles' => [1],
        'manage permissions' => [1],
        'file manager' => [1, 2],
        'Logs' => [1],
        'backups' => [1],

        'Browse student' => [1, 2, 3, 4, 5, 6],
        'Create student' => [1, 2],
        'Update student' => [1, 2],
        'Delete student' => [1, 2],

        'Browse lecturer' => [1, 2],
        'Create lecturer' => [1, 2],
        'Update lecturer' => [1, 2],
        'Delete lecturer' => [1, 2],

        'manage academic advisor' => [1, 2],
        'manage student affairs office' => [1, 2],
        'manage course' => [1, 2],
        'manage class' => [1, 2],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $dbType = config('database.default');
        
        if ($dbType === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($dbType === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF;');
        }

        DB::table(Config::get('permission.table_names.model_has_roles'))->truncate();
        DB::table(Config::get('permission.table_names.role_has_permissions'))->truncate();
        Permission::truncate();
        Role::truncate();

        if ($dbType === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($dbType === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=ON;');
        }

        foreach ($this->roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web']);
        }

        foreach ($this->permissionsRoles as $permission => $roles) {
            Permission::create(['name' => $permission, 'guard_name' => 'web'])->roles()->sync($roles);
        }

        // Super admin on first user
        Role::find(1)->users()->sync([1]);
    }
}
