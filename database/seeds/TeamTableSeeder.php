<?php

use Illuminate\Database\Seeder;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Team::insert([
            ['id' => 1, 'name' => 'Atlanta Hawks'],
            ['id' => 2, 'Chicago Bulls'],
            ['id' => 3, 'name' => 'Los Angeles Lakers'],
            ['id' => 4, 'name' => 'Memphis Grizzlies'],
            ['id' => 5, 'name' => 'Orlando Magic'],
            ['id' => 6, 'name' => 'San Antonio Spurs'],
            ['id' => 7, 'name' => 'Toronto Raptors'],
            ['id' => 8, 'name' => 'Miami Heat']
        ]);
    }
}
