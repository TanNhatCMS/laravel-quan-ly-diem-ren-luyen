<?php

namespace Database\Factories;

use App\Models\Organizations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Organizations>
 */
class OrganizationsFactory extends Factory
{
    protected $model = Organizations::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company, // Tạo tên ngẫu nhiên
            'type' => $this->faker->randomElement(['department', 'faculty']), // Chọn ngẫu nhiên
        ];
    }
}
