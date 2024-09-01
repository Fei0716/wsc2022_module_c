<?php

namespace Database\Seeders;

use App\Models\Games;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game1 = new Games();
        $game1->title = "Demo Game 1";
        $game1->description = "This is demo game 1";
        $game1->slug = "demo-game-1";
        $game1->author_id = 5;
        $game1->save();


        $game2 = new Games();
        $game2->title = "Demo Game 2";
        $game2->description = "This is demo game 2";
        $game2->slug = "demo-game-2";
        $game2->author_id = 6;
        $game2->save();
    }
}
