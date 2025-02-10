<?php

namespace Tests\Feature;

use App\Models\Organizations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrganizationsFactoryTest extends TestCase
{
    use RefreshDatabase; // Reset database sau mỗi test

    #[Test]
    public function it_can_create_an_organization()
    {
        // Tạo một bản ghi từ Factory
        $organization = Organizations::factory()->create();

        // Kiểm tra xem bản ghi có tồn tại trong database không
        $this->assertDatabaseHas('organizations', [
            'id' => $organization->id,
            'name' => $organization->name,
            'type' => $organization->type,
        ]);
    }

    #[Test]
    public function it_creates_valid_type_values()
    {
        // Tạo nhiều bản ghi
        $organizations = Organizations::factory()->count(5)->create();

        // Kiểm tra xem tất cả các bản ghi có type hợp lệ không
        foreach ($organizations as $organization) {
            $this->assertContains($organization->type, ['department', 'faculty']);
        }
    }

    #[Test]
    public function it_creates_unique_names()
    {
        // Tạo nhiều tổ chức
        $organizations = Organizations::factory()->count(10)->create();

        // Kiểm tra xem có bản ghi trùng tên không
        $names = $organizations->pluck('name')->toArray();
        $this->assertCount(count(array_unique($names)), $names);
    }
}
