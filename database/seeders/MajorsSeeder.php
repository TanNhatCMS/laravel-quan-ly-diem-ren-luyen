<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorsSeeder extends Seeder
{
    protected array $major = [
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
        ['id' => 12, 'name' => 'Marketing', 'code' => 'MK'],
        ['id' => 13, 'name' => 'Thương mại điện tử', 'code' => 'TD'],
        ['id' => 14, 'name' => 'Lập trình máy tính', 'code' => 'LM'],
        ['id' => 15, 'name' => 'Hướng dẫn du lịch', 'code' => 'HD'],
        ['id' => 16, 'name' => 'Kinh doanh xuất nhập khẩu', 'code' => 'KX'],
        ['id' => 17, 'name' => 'Truyền thông đa phương tiện', 'code' => 'TT'],
        ['id' => 18, 'name' => 'Thiết kế trang Web', 'code' => 'TW'],
        ['id' => 19, 'name' => 'Tin học ứng dụng', 'code' => 'TH'],
        ['id' => 20, 'name' => 'Thiết kế và quản lý Website', 'code' => 'TW'],
        ['id' => 21, 'name' => 'Vẽ thiết kế mỹ thuật có trợ giúp bằng máy tính', 'code' => 'TM'],
        ['id' => 22, 'name' => 'Kỹ thuật sửa chữa, lắp ráp máy tính', 'code' => 'KM'],
        ['id' => 23, 'name' => 'Quản trị mạng máy tính', 'code' => 'MT'],
        ['id' => 24, 'name' => 'Công nghệ kỹ thuật điện tử thông', 'code' => 'KV'],
        ['id' => 25, 'name' => 'Kế toán doanh nghiệp', 'code' => 'KT'],
        ['id' => 26, 'name' => 'Công nghệ thông tin ( Chất Lượng Cao)', 'code' => 'CLC'],
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
            foreach ($this->major as $major) {
                $existing = DB::table('majors')
                    ->where('name', $major['name'])
                    ->orWhere('id', $major['id'])
                    ->first();
                if ($existing) {
                    DB::table('majors')->where('id', $existing->id)->update([
                        'name' => $major['name'],
                        'updated_at' => now()
                    ]);
                } else {
                    DB::table('majors')->insert(array_merge($major, [
                        'created_at' => now(),
                        'updated_at' => now()
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
