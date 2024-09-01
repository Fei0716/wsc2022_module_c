<?php

namespace Database\Seeders;

use App\Models\Games;
use App\Models\GameVersion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gameversion1 = new GameVersion();
        $gameversion1->version_name = "v1";
        $gameversion1->game_path = "storage/demo-game-1/v1";
        $gameversion1->game_id = 1;
        $gameversion1->save();

        $gameversion2 = new GameVersion();
        $gameversion2->version_name = "v2";
        $gameversion2->game_path = "storage/demo-game-1/v2";
        $gameversion2->game_id = 1;
        $gameversion2->save();

        $gameversion3= new GameVersion();
        $gameversion3->version_name = "v1";
        $gameversion3->game_path = "storage/demo-game-2/v1";
        $gameversion3->game_id = 2;
        $gameversion3->save();
    }
}
