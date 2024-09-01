<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view("users.index")->with([
            "users" => User::where("role", "user")->get(),
        ]);
    }

    public function block(User $user, Request $request)
    {
        $user->blocked_reason = $request->reason;
        $user->save();

        return to_route("users.index");
    }

    public function unblock(User $user, Request $request)
    {
        $user->blocked_reason = null;
        $user->save();

        return to_route("users.index");
    }

    public function show(User $user){
        if($user->blocked_reason){
            abort(404);
        }

        return view("users.show")->with([
            "user" => $user
        ]);
    }
}
