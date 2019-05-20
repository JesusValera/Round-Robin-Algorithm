<?php

use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Image::insert([
            ['id' => 1, 'id_team' => 1, 'source' => 'https://www.nba.com/assets/logos/teams/primary/web/ATL.svg'],
            ['id' => 2, 'id_team' => 2, 'source' => 'https://www.nba.com/assets/logos/teams/primary/web/CHI.svg'],
            ['id' => 3, 'id_team' => 2, 'source' => 'https://rfathead-res.cloudinary.com/image/upload/h_300,w_300/logos/lgo_nba_chicago_bulls.png'],
            ['id' => 4, 'id_team' => 3, 'source' => 'https://www.nba.com/assets/logos/teams/primary/web/LAL.svg'],
            ['id' => 5, 'id_team' => 4, 'source' => 'https://www.nba.com/assets/logos/teams/primary/web/MEM.svg'],
            ['id' => 6, 'id_team' => 5, 'source' => 'https://www.nba.com/assets/logos/teams/primary/web/ORL.svg'],
            ['id' => 8, 'id_team' => 7, 'source' => 'https://www.nba.com/assets/logos/teams/primary/web/TOR.svg'],
            ['id' => 9, 'id_team' => 8, 'source' => 'https://www.nba.com/assets/logos/teams/primary/web/MIA.svg'],
        ]);
    }
}
