<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Games;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function destroy(Games $game, Request $request){
        //check whether the user is the author of the game

        if($game->author->username !== $request->user()->username){
            return response()->json([
                "status" => "forbidden",
                "message" => "You are not the author",
            ], 403);
        }
        foreach($game->gameVersions as $v){
            foreach($v->scores as $s){
                $s->deleted_at = now();
                $s->save();
            }
            $v->deleted_at = now();
            $v->save();
        }

        $game->deleted_at = now();
        $game->save();

        return response('' , 204);
    }
    public function store( Request $request)
    {

        $validated = $request->validate([
            "title" => "required|min:3|max:60",
            "description" =>"required|min:0|max:200"
        ]);

        $slug = implode('-',explode(" ",trim(strtolower($validated["title"]))  ) );


        //check for unique of slug
        $duplicated = Games::where("slug", $slug)->exists();
        if($duplicated){
            return response()->json([
                "status" => "invalid",
                "slug" => "Game title already exists",
            ], 400);
        }

        //store the game in the database
        $game  = new Games();
        $game->title = $validated["title"];
        $game->description = $validated["description"];
        $game->author_id = $request->user()->id;
        $game->slug = $slug;
        $game->save();

        return response()->json([
            "status" => "success",
            "slug" => $slug,
        ] , 201);
    }
    public function update(Games $game , Request $request)
    {
        //check whether the user is the author of the game

        if($game->author->username !== $request->user()->username){
            return response()->json([
                "status" => "forbidden",
                "message" => "You are not the author",
            ], 403);
        }

        $validated = $request->validate([
            "title" => "required",
            "description" => "required"
        ]);

        $game->title = $validated["title"];
        $game->description = $validated["description"];
        $game->save();

        return response()->json([
            "status" => "success"
        ] , 200);
    }

    public function show(Games $game){
        $res = [
            "slug"=> $game->slug,
            "title"=> $game->title,
            "description"=> $game->description,
            "thumbnail" => $game->thumbnail,
            "uploadTimestamp" => $game->created_at,
            "author" => $game->author->username,
            "scoreCount"=> $game->scores()->count(),
            "gamePath" => $game->gameVersions()->orderByDesc("id")->pluck("game_path")->first(),
        ];
        return response()->json($res, 200);
    }
}
