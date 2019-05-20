<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TeamTableSeeder::class);
        $this->call(ImageTableSeeder::class);
    }
}
