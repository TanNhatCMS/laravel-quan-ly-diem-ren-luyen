<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationsSeeder extends Seeder
{

    /**
     * List of organizations.
     */
    protected $organizations = [
        ['name' => 'Phòng Đào Tạo', 'type' => 'department'],
        ['name' => 'Phòng Công Tác Sinh Viên', 'type' => 'department'],
        ['name' => 'Khoa Công Nghệ Thông Tin', 'type' => 'faculty'],
        ['name' => 'Khoa Kinh Tế', 'type' => 'faculty'],
        ['name' => 'Phòng Hành Chính', 'type' => 'department'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('organizations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('organizations')->insert(array_map(function ($organization) {
            return [
                'name' => $organization['name'],
                'type' => $organization['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $this->organizations));
    }
}
