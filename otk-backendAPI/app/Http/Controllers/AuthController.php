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
            $token = $user->createToken('userToken')->plainTextToken;
        }
        else if($user = Admin::where('email', $fields['email'])->first()){
            $userType = 2;
            $token = $user->createToken('adminToken')->plainTextToken;
        }
        else if($user = Judge::where('email', $fields['email'])->first()){
            $userType = 3;
            $token = $user->createToken('judgeToken')->plainTextToken;
        }
        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return Response([
                'message' => 'Bad login credentials',
            ], 401);
        }
        

        //$token = $user->createToken('userToken')->plainTextToken;
        
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
        return response([
            'user' => Auth::user(),
        ]);
    }

    public function changePassword(Request $request) {
        $fields = $request->validate([
            'oldPassword' => 'required',
            'password' => 'required|min:6|string|confirmed',
            'user_type' => 'required',
        ],
        [
            'oldPassword.required' => 'A régi jelszó megadása kötelező!',
            'email.required' => 'Az email megadása kötelező!',
            'password.required' => 'A jelszó megadása kötelező!',
            'name.required' => 'A név megadása kötelező!',
            'password.min' => 'A jelszónak legalább 6 karakter hosszúnak kell lennie!',
            'password.confirmed' => 'A két jelszó nem egyezik!',
            'password.string' => 'Hibás formátum!',
            'user_type' => 'Hiba történt..'
            
        ]);

        $user = Auth::user();

        if(!$user || !Hash::check($fields['oldPassword'], $user->password)){
            return Response([
                'password' => 'A régi jelszó hibás!',
            ], 401);
        }

        $user->fill([
            'password' => bcrypt($fields['password']),
        ]);
        $user->save();

        return response([
            'message' => 'Success'
        ]);
    }
}
