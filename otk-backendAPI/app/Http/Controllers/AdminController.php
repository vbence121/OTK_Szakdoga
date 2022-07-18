<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'required|string',
            'email' => 'required|string|unique:admin,email',
            'password' => 'required|string|confirmed'
        ]);

        //$now = date('Y-m-d H:i:s');

        $user = Admin::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
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

        $user = Admin::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if((auth()->user()->tokens->first()['name'] != 'adminToken')){  // Stop users withouth adminToken from accessing protected functions
            return response(
                ['result' => 'Bad Token. Unauthorized access of endpoint'], 
                403
            );
        }
        return Admin::destroy($id);
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


    /**
     * Log the user out and delete tokens
     * 
     * 
     * return \Illuminate\Http\Response
     */
    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out!',
            'result' => '1'
        ];
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

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
