<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    //
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            "name"=>'required|string|max:255',
            "email"=>'required|email|max:255',
            "password"=>'required|min:8|confirmed',
        ]);


        if($validator->fails()){
            return response()->json([
                "errors"=>$validator->errors()
            ],301);
        }

        $password = password_hash($request->password,PASSWORD_DEFAULT);
        $access_token = Str::random(64);

        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$password,
            "access_token"=>$access_token,
        ]);

        if(empty($user)){
            return response()->json([
                "errors" => ["Error while Registering"]
            ],500);
        }

        return response()->json([
            "msg" => "Your Account has been Registered",
            "access_token" => $access_token,
        ],201);
    }


    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email"=>'required|email|max:255',
            "password"=>'required|min:8',
        ]);


        if($validator->fails()){
            return response()->json([
                "errors"=>$validator->errors()
            ],301);
        }

        $user = User::where("email",$request->email)->first();

        if(!$user){
            return  response()->json([
                "errors"=>["Credentials aren't correct"]
            ],301);
        }

        $passwordVerified = password_verify($request->password,$user->password);

        if(!$passwordVerified){
            return  response()->json([
                "errors"=>["Credentials aren't correct"]
            ],301);
        }

        $access_token = Str::random(64);

        $user->update([
            "access_token"=>$access_token,
        ]);


        return response()->json([
            "msg" => "Your Account has been Logged in",
            "access_token" => $access_token,
        ],201);
    }

    public function logout(Request $request){
        $access_token = $request->header("access_token");
        if(empty($access_token)){
            return response()->json([
                "errors"=>["Access Token is required"]
            ],301);
        }


        $user = User::where("access_token","=",$access_token)->first();

        if(empty($user)){
            return  response()->json([
                "errors"=>["User Not Found or Not logged In"]
            ],404);
        }

        $user->update([
            "access_token"=>null
        ]);
        return response()->json([
            "msg"=>"User has been Logged Out"
        ],200);

    }
}
