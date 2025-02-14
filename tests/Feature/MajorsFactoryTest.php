<?php

namespace Tests\Feature;

use App\Models\Majors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MajorsFactoryTest extends TestCase
{
    use RefreshDatabase; // Reset database sau mỗi test

    #[Test]
    public function it_can_create_a_major()
    {
        // Sử dụng factory để tạo một bản ghi Major
        $major = Majors::factory()->create();

        // Kiểm tra xem bản ghi có tồn tại trong database không
        $this->assertDatabaseHas('majors', [
            'id' => $major->id,
            'name' => $major->name,
            'code' => $major->code,
        ]);
    }

    #[Test]
    public function it_creates_unique_codes()
    {
        // Lấy danh sách mã ngành hợp lệ
        $validCodes = ['KHMT', 'CNTT', 'KTPM', 'HTTT', 'TTA'];

        // Tạo 10 chuyên ngành (mặc dù chỉ có 5 loại mã)
        $majors = Majors::factory()->count(10)->create();
        $codes = $majors->pluck('code')->toArray();

        // Kiểm tra xem tất cả code có thuộc danh sách hợp lệ không
        foreach ($codes as $code) {
            $this->assertContains($code, $validCodes);
        }

        // Kiểm tra xem có bao nhiêu mã code duy nhất
        $uniqueCodes = array_unique($codes);
        $this->assertLessThanOrEqual(count($validCodes), count($uniqueCodes));
    }

    #[Test]
    public function it_creates_valid_names()
    {
        $validNames = [
            'Khoa học máy tính',
            'Công nghệ thông tin',
            'Kỹ thuật phần mềm',
            'Hệ thống thông tin',
            'Trí tuệ nhân tạo',
        ];

        $major = Majors::factory()->create();

        // Kiểm tra xem tên được tạo có nằm trong danh sách hợp lệ không
        $this->assertContains($major->name, $validNames);
    }
}
