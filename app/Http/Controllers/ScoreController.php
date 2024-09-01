<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function destroy(Score $score)
    {
        $score->deleted_at = now();
        $score->save();
        return redirect()->back();
    }

    public function resetScore(Games $game)
    {
        //loop through each of the game versions
        foreach($game->gameVersions as $v){
            foreach($v->scores as $s){
                $s->deleted_at = now();
                $s->save();
            }
        }

        return redirect()->back();
    }

    public function deletePlayerScores(User $user){
        //loop through each of the scores of the player
        foreach($user->scores as $s){
            $s->deleted_at = now();
            $s->save();
        }

        return redirect()->back();
    }
}
