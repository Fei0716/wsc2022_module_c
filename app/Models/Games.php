<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;
    public $table  = "games";
    public $primaryKey = "id";
    public function author(){
        return $this->belongsTo(User::class, "author_id", "id");
    }

    public function gameVersions(){
        return $this->hasMany(GameVersion::class, "game_id", "id");

    }
    public function scores(){
        return $this->hasManyThrough(Score::class, GameVersion::class , "game_id", "game_version_id");
    }

    public function latestVersion(){
        return $this->gameVersions()->orderByDesc("id")->first();
    }

    //adjust the params for the route of users
    public function getRouteKeyName()
    {
        return 'slug';
    }



}
