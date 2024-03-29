<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\AuthController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|string|unique:users',
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'company' => 'nullable|string',
            'phone' => 'nullable|string',
            'password' => 'required|min:6|string|confirmed'
        ],
        [
            'email.unique' => 'Ez az email már foglalt!',
            'email.required' => 'Az email megadása kötelező!',
            'password.required' => 'A jelszó megadása kötelező!',
            'name.required' => 'A név megadása kötelező!',
            'password.min' => 'A jelszónak legalább 6 karakter hosszúnak kell lennie!',
            'password.confirmed' => 'A két jelszó nem egyezik!'
            
        ]);
        

        $user = User::create([
            'username' => $fields['username'],
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'company' => $fields['company'],
            'phone' => $fields['phone'],
            'user_type' => 1,
            //'created-at' => $now,
            //'updated-at' => $now
        ]);

        /*
        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];
        */
        
        event(new Registered($user));

        return response("success", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'string|unique:users',
            'name' => 'string',
            'email' => 'string|unique:users,email',
            'company' => 'string|nullable',
            'phone' => 'string'
        ],
        [
            'email.unique' => 'Ez az email már foglalt!',
            'email.required' => 'Az email megadása kötelező!',
            'name.string' => 'A név megadása kötelező!',
            'phone.string' => 'A telefonszám hibás!',
            'username.unique' => 'A felhasználónév foglalt!',
            'username.string' => 'A felhasználónév hibás!',
        ]);
        
        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if(($tokenType == "userToken" && $tokenID == $id) OR $tokenType == "adminToken"){   //check if either the request arrived from admin or the user 
            $user = User::find($id);
            $user->update($request->all());
            return $user;
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        $fields = $request->validate([
            'password' => 'required|string'
        ],
        [
            'password.required' => 'Adja meg a jelszavát!',
            'password.string' => 'Hibás formátum!',
        ]);
        $user = Auth::user();
        $id = Auth::user()->id;

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return Response([
                'password' => 'A jelszó hibás!',
            ], 401);
        }

        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if(($tokenType == "userToken" && $tokenID == $id) OR $tokenType == "adminToken"){   //check if either the request arrived from admin or the user wants to delete themself
            auth()->user()->tokens()->delete();
            $cookie = Cookie::forget('jwt');
            User::destroy($id);
            return response([
                'message' => 'Success'
            ])->withCookie($cookie);
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    /**
     * Search for User based on Name
     * 
     * @param str $name
     * @return \Illuminate\Http\Response
     */
    public function search($name){
        return User::where('name', 'like', '%'.$name)->get();
    }

    public function searchCustom($type, $name){
        return User::where($type, 'like', '%'.$name)->get();
    }
}
