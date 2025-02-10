<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorsSeeder extends Seeder
{
    protected array $major_list = [
        'Công Nghệ Thông Tin' => 'CT',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('majors')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($this->major_list as $name => $code) {
            DB::table('majors')->insert([
                'name' => $name,
                'code' => $code,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
