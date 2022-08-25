<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Admin::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if((auth()->user()->tokens->first()['name'] != 'adminToken')){ // Stop users withouth adminToken from accessing protected functions
            return response(
                ['result' => 'Bad Token. Unauthorized access of endpoint'], 403
            );
        }
        
        $fields = $request->validate([
            'username' => 'required|string|unique:admins',
            'name' => 'required|string',
            'email' => 'required|string|unique:admins,email',
            'password' => 'required|string|confirmed'
        ],
        [
            'email.unique' => 'Ez az email már foglalt!',
            'email.required' => 'Az email megadása kötelező!',
            'password.required' => 'A jelszó megadása kötelező!',
            'name.required' => 'A név megadása kötelező!',
            'password.min' => 'A jelszónak legalább 6 karakter hosszúnak kell lennie!',
            'password.confirmed' => 'A két jelszó nem egyezik!'
            
        ]);

        //$now = date('Y-m-d H:i:s');

        $user = Admin::create([
            'username' => $fields['username'],
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'user_type' => 2,
            //'created-at' => $now,
            //'updated-at' => $now
        ]);

        $token = $user->createToken('adminToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Admin::find($id);
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
        if((auth()->user()->tokens->first()['name'] != 'adminToken')){ // Stop users withouth adminToken from accessing protected functions
            return response(
                ['result' => 'Bad Token. Unauthorized access of endpoint'], 403
            );
        }

        $request->validate([
            'username' => 'string|unique:users',
            'name' => 'string',
            'email' => 'string|unique:users,email',
            'password' => 'min:6|string|confirmed'
        ]);

        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if(($tokenType == "admin" && $tokenID == $id)){   //check if either the request arrived from the user 
            $user = Admin::find($id);
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
    public function destroy(Request $request, $id)
    {
        if((auth()->user()->tokens->first()['name'] != 'adminToken')){  // Stop users withouth adminToken from accessing protected functions
            return response(
                ['result' => 'Bad Token. Unauthorized access of endpoint'], 
                403
            );
        }
        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if($tokenType == "adminToken" && $tokenID == $id){   //check if either the request arrived from admin or the user
            AdminController::logout($request);
            return Admin::destroy($id);
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    /**
     * Search for Judge based on Name
     * 
     * @param str $name
     * @return \Illuminate\Http\Response
     */
    public function search($name){
        return Admin::where('name', 'like', '%'.$name)->get();
    }
    public function searchCustom($type, $name){
        return Admin::where($type, 'like', '%'.$name)->get();
    }

    /**
     * Log the user out and delete tokens
     * 
     * 
     * return \Illuminate\Http\Response
     */
    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }

    /**
     *  Log the user in and create tokens
     */
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //check if user exists
        $user = Admin::where('email', $fields['email'])->first();
        
        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return Response([
                'message' => 'Bad login credentials',
            ], 401);
        }

        $token = $user->createToken('adminToken')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // egy nap

        return response([
            'user' => $user
        ])->withCookie($cookie);
    }

    public function admin(){
        return Auth::user();
    }
}
