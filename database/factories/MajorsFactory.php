<?php

namespace Database\Factories;

use App\Models\Majors;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Majors>
 */
class MajorsFactory extends Factory
{
    protected $model = Majors::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $majors = [
            'Khoa học máy tính' => 'KHMT',
            'Công nghệ thông tin' => 'CNTT',
            'Kỹ thuật phần mềm' => 'KTPM',
            'Hệ thống thông tin' => 'HTTT',
            'Trí tuệ nhân tạo' => 'TTA',
        ];
        $name = $this->faker->randomElement(array_keys($majors));
        $code = $majors[$name];
        return [
            'name' => $name,
            'code' => $code,
        ];
    }
}
