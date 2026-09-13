<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // เรียก Seeder ที่ต้องการ
        $this->call(CreateUsersSeeder::class);
    }
}
