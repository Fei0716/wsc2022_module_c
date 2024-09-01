<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Games;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function getHighscores(Games $game, Request $request)
    {
        $highscores = Score::select(DB::raw("max(score) as score, user_id, created_at" ))->whereHas("user", function($query){
           $query->whereNull("blocked_reason");
        })->whereIN("game_version_id", $game->gameVersions->pluck("id")
        )->groupBy("user_id", "created_at")->get();

        $res = $highscores->map( function($h){
            return [
                "username" => User::where([
                    "id" => $h->user_id,
                ])->pluck("username")->first(),
                "score" => $h->score,
                "timestamp"=> $h->created_at
             ];
        });

        return response()->json([
            "scores" => $res
        ], 200);
    }

    public function postScore(Games $game, Request $request)
    {
        $latestVersion = $game->gameVersions()->orderByDesc("id" )->first();
        $score = new Score();
        $score->score = $request->score;
        $score->game_version_id = $latestVersion->id;
        $score->user_id = $request->user()->id;
        $score->save();

        return response()->json([
            "status" => "success"
        ], 201);
    }
}
