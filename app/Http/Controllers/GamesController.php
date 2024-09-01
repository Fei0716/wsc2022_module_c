<?php

namespace App\Http\Controllers;

use App\Models\Games;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index()
    {
        $games = Games::get();
        return view("games.index")->with([
            "games" => $games
        ]);
    }

    public function destroy(Games $game){
        //soft delete the game from the db
        $game->deleted_at = now();
        $game->save();

        return to_route("games.index");
    }
    public function show(Games $game)
    {
        //get all the scores for the game
        $scores = $game->scores()->get()->filter(function ($row){
                return $row->user->blocked_reason === null;
        });
        return view("games.show")->with([
            "scores" => $scores,
            "game" => $game
        ]);
    }
}
