<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Judge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // admin létreozása az adatbázisban teszteléshez

        /* $user = Admin::create([
            'username' => 'admin',
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt($fields['password']),
            'user_type' => 2,
            //'company' => $fields['company'],
            //'phone' => $fields['phone']
            //'created-at' => $now,
            //'updated-at' => $now
        ]);
        return; */


        //check if user exists
        if($user = User::where('email', $fields['email'])->first()){
            $userType = 1;
        }
        else if($user = Admin::where('email', $fields['email'])->first()){
            $userType = 2;
        }
        else if($user = Judge::where('email', $fields['email'])->first()){
            $userType = 3;
        }
        
        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return Response([
                'message' => 'Bad login credentials',
            ], 401);
        }

        $token = $user->createToken('userToken')->plainTextToken;
        
        $cookie = cookie('jwt', $token, 60 * 24); // egy nap
        
        return response([
            'user' => $user,
        ])->withCookie($cookie);
    }

    public function logout(){
        //$tokenType = auth()->user()->tokens->first()['name'];

        auth()->user()->tokens()->delete();

        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }

    public function user(){
        return Auth::user();
    }
}
