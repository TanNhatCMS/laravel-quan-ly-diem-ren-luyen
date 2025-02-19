<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! DB::table('users')->where('id', 1)->exists()) {
            DB::table('users')->insert([
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin@1234'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->call([
            AcademicDegreesSeeder::class,
            MajorsSeeder::class,
            OrganizationsSeeder::class,
            PermissionManagerTablesSeeder::class,
            PositionsSeeder::class,
        ]);
    }
}
