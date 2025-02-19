<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    protected array $positions = [
        ['id' => 1, 'name' => 'Trưởng phòng'],
        ['id' => 2, 'name' => 'Phó trưởng phòng'],
        ['id' => 3, 'name' => 'Nhân viên'],
        ['id' => 4, 'name' => 'Lập trình viên'],
        ['id' => 5, 'name' => 'Kế toán'],
        ['id' => 6, 'name' => 'Nhân viên hành chính'],
        ['id' => 7, 'name' => 'Thư Ký'],
        ['id' => 8, 'name' => 'Cố Vấn Học Tập'],
        ['id' => 9, 'name' => 'Sinh Viên'],
        ['id' => 10, 'name' => 'Lớp Trưởng'],
        ['id' => 11, 'name' => 'Lớp Phó'],
        ['id' => 12, 'name' => 'Trưởng Khoa'],
        ['id' => 13, 'name' => 'Phó Khoa'],
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
            foreach ($this->positions as $position) {
                $existing = DB::table('positions')
                    ->where('name', $position['name'])
                    ->orWhere('id', $position['id'])
                    ->first();
                if ($existing) {
                    DB::table('positions')->where('id', $existing->id)->update([
                        'name' => $position['name'],
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::table('positions')->insert(array_merge($position, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]));
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
