<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $access_token = $request->header("access_token");
        if(empty($access_token)){
           return response()->json([
            "errors"=>["Access Token is required"]
           ],400);
        }

        $user = User::where("access_token",$access_token)->first();
        if(empty($user)){
            return response()->json([
            "errors"=>["User Not Found"]
           ],401);
        }
        if($user->role == 0){
            return response()->json([
                "errors"=>["User isn't authorized"]
            ],403);
        }
        return $next($request);
    }
}
