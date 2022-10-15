<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use HttpResponses;

    public function signup(Request $req){
        $req->validate([
            "name" => ['required', 'string', 'max:50'],
            "email" => ['required', 'string', 'max:255', 'unique:users'],
            "password" => ['required', 'confirmed', Password::defaults()]
        ]);
        $user =  User::create([
            "name" => $req->name,
            "password" => Hash::make($req->password),
            "email" => $req->email
        ]);

        return $this->success([
            'user' => $user,
            "token" => $user->createToken("Api Token Of".$user->name)->plainTextToken
        ]);
    }
    // login
    public function login(Request $req){
        $req->validate([
            "email" => ['required', 'string', 'max:255'],
            "password" => ['required', 'string']
        ]);
        if(!Auth::attempt($req->only("email", "password"))){
            return $this->error([
                "message" => "Invalid Credentials",
                "data" => $req->only("email", "password")
            ], 401);
        }
        $user = User::where("email", $req->email)->first();
        return $this->success([
            'user' => $user,
            "token" => $user->createToken("Api Token Of".$user->name)->plainTextToken
        ]);
    }
    // logout
    public function logout(Request $req){
        $req->user()->tokens()->delete();
        return $this->success([
            "message" => "Logged Out Successfully",
            "data" => ""
        ]);
    }
}
