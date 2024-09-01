<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            "username" => "required",
            "password" => "required",
        ]);

        $user = User::where([
            "username" => $validated["username"],
        ])->first();

        if($user && Hash::check($validated["password"] , $user->password)){
            //login the user
            Auth::login($user);
            //update the last login timestamp
            $user->last_login = now();
            $user->save();

            return to_route("getAdminUsers");
        }

        return back()->withErrors([
            "username" => "Username or password is incorrect",
        ]);
    }
    public function logout(Request $request)
    {
        //update the last login timestamp
        $user = User::where('id' , Auth::user()->id)->first();
        $user->last_login = now();
        $user->save();

        Auth::logout();
        return to_route("loginPage");
    }


    public function getAdminUsers(){
        $admins = User::where([
            "role" => "admin"
        ])->get();

        return view("admins.index")->with([
            "admins" => $admins
        ]);
    }


//    for APIS
    public function signup(Request $request)
    {
        $validated = $request->validate([
            "username" => "required|unique:users|min:4|max:60",
            "password" => "required|min:8|max:65536"
        ]);

        $user  = new User();
        $user->username = $validated["username"];
        $user->password = $validated["password"];
        $user->role = "user";
        $user->save();

        //create token
        $token = $user->createToken($user->username , ["*"], now()->addHour());

        //return the token back to the front end
        return response()->json([
            "token" => $token->plainTextToken,//plainTextTokenHere
            "status" => "success",
        ], 201);

    }

    public function signin(Request $request)
    {
        $validated = $request->validate([
            "username" => "required|min:4|max:60",
            "password" => "required|min:8|max:65536"
        ]);

        $user  = User::where([
            "username" => $validated["username"]
        ])->first();

        if($user && Hash::check($validated["password"], $user->password))
        {
            //create token
            $token = $user->createToken($user->username , ["*"], now()->addHour());
            $user->last_login = now();
            $user->save();
            //return the token back to the front end
            return response()->json([
                "token" => $token->plainTextToken,//plainTextTokenHere
                "status" => "success",
            ], 201);
        }

        return response()->json([
            "status" => "invalid",
            "message" => "Wrong username or password"
        ], 201);

    }

    public function signout(Request $request)
    {
        //update last login
        $user = User::where([
            "username"  => $request->user()->username
        ])->first();
        $user->last_login = null;
        $user->save();
        //remove the token
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
