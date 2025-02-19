<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicDegreesSeeder extends Seeder
{
    protected array $academic_degrees = [
        ['id' => 1, 'name' => 'Giáo Sư'],
        ['id' => 2, 'name' => 'Phó Giáo Sư'],
        ['id' => 3, 'name' => 'Tiến Sĩ'],
        ['id' => 4, 'name' => 'Thạc Sĩ'],
        ['id' => 5, 'name' => 'Cử Nhân'],
        ['id' => 6, 'name' => 'Trung Cấp Chuyên Nghiệp'],
        ['id' => 7, 'name' => 'Sơ Cấp'],
        ['id' => 8, 'name' => 'Kỹ Sư'],
        ['id' => 9, 'name' => 'Cử nhân kỹ thuật'],
        ['id' => 10, 'name' => 'Thạc sĩ quản trị kinh doanh'],
        ['id' => 11, 'name' => 'Cử nhân kinh tế'],
        ['id' => 12, 'name' => 'Thạc sĩ công nghệ thông tin'],
        ['id' => 13, 'name' => 'Cử nhân xã hội học'],
        ['id' => 14, 'name' => 'Thạc sĩ thiết kế đồ họa'],
        ['id' => 15, 'name' => 'Cử nhân marketing'],
        ['id' => 16, 'name' => 'Thạc sĩ tài chính'],
        ['id' => 17, 'name' => 'Tiến sĩ kinh tế'],
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
            foreach ($this->academic_degrees as $degree) {
                $existing = DB::table('academic_degrees')
                    ->where('name', $degree['name'])
                    ->orWhere('id', $degree['id'])
                    ->first();
                if ($existing) {
                    DB::table('academic_degrees')->where('id', $existing->id)->update([
                        'name' => $degree['name'],
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::table('academic_degrees')->insert(array_merge($degree, [
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
