<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorsSeeder extends Seeder
{
    protected array $major_list = [
        ['id' => 1, 'name' => 'Công nghệ thông tin', 'code' => 'CT'],
        ['id' => 2, 'name' => 'Truyền thông và mạng máy tính', 'code' => 'TM'],
        ['id' => 3, 'name' => 'Hệ thống thông tin', 'code' => 'HT'],
        ['id' => 4, 'name' => 'Công nghệ kỹ thuật điện tử, truyền thông', 'code' => 'KD'],
        ['id' => 5, 'name' => 'Công nghệ kỹ thuật điều khiển và tự động hóa', 'code' => 'DT'],
        ['id' => 6, 'name' => 'Công nghệ kỹ thuật máy tính', 'code' => 'CM'],
        ['id' => 7, 'name' => 'Quản trị kinh doanh', 'code' => 'QT'],
        ['id' => 8, 'name' => 'Kế toán', 'code' => 'KT'],
        ['id' => 9, 'name' => 'Tài chính - ngân hàng', 'code' => 'NH'],
        ['id' => 10, 'name' => 'Thiết kế đồ họa', 'code' => 'ĐH'],
        ['id' => 11, 'name' => 'Logistics', 'code' => 'LG'],
        ['id' => 12, 'name' => 'Ngành Marketing', 'code' => 'MK'],
        ['id' => 13, 'name' => 'Ngành thương mại điện tử', 'code' => 'TD'],
        ['id' => 14, 'name' => 'Ngành lập trình máy tính', 'code' => 'LM'],
        ['id' => 15, 'name' => 'Ngành hướng dẫn du lịch', 'code' => 'HD'],
        ['id' => 16, 'name' => 'Ngành kinh doanh xuất nhập khẩu', 'code' => 'KX'],
        ['id' => 17, 'name' => 'Truyền thông đa phương tiện', 'code' => 'TT'],
        ['id' => 18, 'name' => 'Thiết kế trang Web', 'code' => 'TW']
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('majors')->truncate();
            DB::statement('ALTER TABLE majors AUTO_INCREMENT = 19;');
            DB::table('majors')->insert(array_map(function ($major) {
                return array_merge(['created_at' => now(), 'updated_at' => now()], $major);
            }, $this->major_list));

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
