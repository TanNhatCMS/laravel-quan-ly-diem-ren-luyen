<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationsSeeder extends Seeder
{
    /**
     * List of organizations.
     */
    protected array $organizations = [
        ['name' => 'Khoa Công Nghệ Thông Tin - Điện Tử', 'type' => 'faculty'],
        ['name' => 'Khoa Kinh Tế', 'type' => 'faculty'],
        ['name' => 'Khoa Đại Cương', 'type' => 'faculty'],
        ['name' => 'Phòng Công Tác Sinh Viên', 'type' => 'department'],
        ['name' => 'Phòng Đào Tạo', 'type' => 'department'],
    ];

    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            DB::table('organizations')->upsert(
                array_map(fn ($organization) => [
                    'name' => $organization['name'],
                    'type' => $organization['type'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ], $this->organizations),
                ['name'],
                ['type', 'updated_at']
            );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
