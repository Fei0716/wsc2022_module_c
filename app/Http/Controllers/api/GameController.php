<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Games;
use App\Models\GameVersion;
use Illuminate\Http\Request;
use ZipArchive;

class GameController extends Controller
{

    public function index(Request $request)
    {
        $validated = $request->validate([
            //sort by
            "page" => "min:0",
            "size" => "min:1",
            "sortBy" => "in:title,popular,uploaddate",
            "title" => "in:asc,desc",
        ]);

        //setup the default values
        $page = $request->input("page", 0);
        $size = $request->input("size", 10);
        $sortBy = $request->input("sortBy", "title");
        $sortDir = $request->input("sortDir", "asc");

        // If there is a game that has no game version yet, it is not included in the response nor the total count.
        $query = Games::whereNull('deleted_at')->whereHas("gameVersions", function($query){
            $query->whereNotNull("id");
        });


        $totalElements = $query->count();
        $data =  $query
            ->skip($page * $size)
            ->take($size)
            ->get();

        return response()->json([
            "page" => $page,
            "size" => $size,
            "totalElements" => $totalElements,
            "content" => $data->map(function($g){
                return [
                    "slug" => $g->slug,
                    "title" => $g->title,
                    "description" => $g->description,
                    "thumbnail" => $g->thumbnail,
                    "uploadTimestamp" => $g->latestVersion()->first()->created_at,
                    "author" => $g->author->username,
                    "scoreCount" => $g->scores->count(),
                ];
            }),
        ] , 200);

    }

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

    public function uploadNewVersion(Games $game , Request $request)
    {
        //check whether the user is the author of the game
        if($request->user()->id !== $game->author_id){
            return response()->json([
                "status" => "forbidden",
                "message" => "You are not the author",
            ], 403);
        }

        //check whether the file exist
        $validated = $request->validate([
            "zipfile" => "required|file",
            "token" => "required",
        ]);

        //extract the zip file to public dir
        $zip = new ZipArchive();
        //check whether the zipfile can be open
        if(!$zip->open($request->file("zipfile")->getRealPath())){
            return back()->withErrors("Zip file cannot be opened");
        }

        //check whether there's index.html
//        if(!$zip->locateName("index.html")){
//            return response("Zip file must contain index.html",  400);
//        }

        //check file size
        $maxSize = 100 * 1024 * 1024;//100mb
        if($request->file("zipfile")->getSize() > $maxSize){
            return response("Zip file's size exceeds 100mb" , 400);
        }

        $version = $game->latestVersion();

        $latestVersionNumber = (int)preg_replace('/v/',"", $version->version_name) + 1;
        $latestVersion = 'v'.$latestVersionNumber;

        //create the path for the new version file
        $dir = "storage/".$game->slug."/";
        $path = $dir. $latestVersion;

        $newVersion = new GameVersion();
        $newVersion->version_name = $latestVersion;
        $newVersion->game_path = $path;
        $newVersion->game_id = $game->id;
        $newVersion->save();


        //unzip and store in the file system
        $zip->extractTo($path);
        $zip->close();

        return response("New Version Created", 201);
    }
}
