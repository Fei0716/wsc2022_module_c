<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show(User $user, Request $request)
    {
        //games that the player played
        $highscoreData = Score::join("game_versions", "game_versions.id", "scores.game_version_id")->join("games", "games.id", "game_versions.game_id")->where([
            "scores.user_id" => $user->id,
        ])->select(DB::raw("max(score) as score, games.id , games.title , games.description , games.slug , games.created_at"))->groupBy("games.id", "games.title" , "games.slug", "games.created_at" )->get();

        return response()->json([
            "username" => $user->username,
            "registeredTimestamp" => $user->created_at,
            "authoredGames" => $user->games->map(function($g) use ($user, $request) {
                // Check if the game has no versions
                if ($g->gameVersions()->count() === 0) {
                    // If the user is the owner of the account being viewed, include games with no versions
                    if ($user?->id === $request?->user()?->id) {
                        return [
                            "slug" => $g->slug,
                            "title" => $g->title,
                            "description" => $g->description,
                        ];
                    } else {
                        // Skip this game if the user is not the owner and there are no versions
                        return null;
                    }
                }

                // Include games with at least one version
                return [
                    "slug" => $g->slug,
                    "title" => $g->title,
                    "description" => $g->description,
                ];
            })->filter(), // Filter out the null values
            "highscores" => $highscoreData->map(function($row){
                return [
                    "game" => [
                        "slug" => $row->slug,
                        "title" =>  $row->title,
                        "description" =>  $row->description,
                    ],
                    "score" => $row->score,
                    "timestamp" => $row->created_at,
                ];
            }),
        ], 200);
    }
}
