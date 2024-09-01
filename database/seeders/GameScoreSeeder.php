<?php

namespace Database\Seeders;

use App\Models\GameVersion;
use App\Models\Score;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $score1 = new Score();
        $score1->score = 10;
        $score1->user_id = 3;
        $score1->game_version_id = 1;
        $score1->save();

        $score2 = new Score();
        $score2->score = 15;
        $score2->user_id = 3;
        $score2->game_version_id = 1;
        $score2->save();

        $score3 = new Score();
        $score3->score = 12;
        $score3->user_id = 3;
        $score3->game_version_id = 2;
        $score3->save();



        $score4 = new Score();
        $score4->score = 20;
        $score4->user_id = 4;
        $score4->game_version_id = 2;
        $score4->save();

        $score5 = new Score();
        $score5->score = 30;
        $score5->user_id = 4;
        $score5->game_version_id = 3;
        $score5->save();



        $score6 = new Score();
        $score6->score = 1000;
        $score6->user_id = 5;
        $score6->game_version_id = 2;
        $score6->save();

        $score7 = new Score();
        $score7->score = -300;
        $score7->user_id = 5;
        $score7->game_version_id = 2;
        $score7->save();

        $score8 = new Score();
        $score8->score = 5;
        $score8->user_id = 6;
        $score8->game_version_id = 2;
        $score8->save();

        $score8 = new Score();
        $score8->score = 200;
        $score8->user_id = 6;
        $score8->game_version_id = 3;
        $score8->save();

    }
}
