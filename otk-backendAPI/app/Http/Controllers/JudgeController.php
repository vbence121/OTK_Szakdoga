<?php

namespace App\Http\Controllers;

use App\Models\Judge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class JudgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Judge::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->user_type !== 2) { // Stop users with simple userToken from accessing protected functions
            return response(
                ['result' => 'Bad Token. Unauthorized access of endpoint.'], 
                403
            );
        }
        
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users|unique:admins|unique:judges,email',
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

        //$now = date('Y-m-d H:i:s');

        $user = Judge::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'user_type' => 3,
            //'created-at' => $now,
            //'updated-at' => $now
        ]);

        $token = $user->createToken('judgeToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

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
        return Judge::find($id);
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
        if(auth()->user()->tokens->first()['name'] == 'userToken'){ // Stop users with simple userToken from accessing protected functions
            return response(
                ['result' => 'Bad Token. Unauthorized access of endpoint.'], 
                403
            );
        }

        $request->validate([
            'username' => 'string|unique:Judges',
            'name' => 'string',
            'email' => 'string|unique:Judges,email',
            'password' => 'min:6|string|confirmed'
        ]);

        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if(($tokenType == "judgeToken" && $tokenID == $id) OR $tokenType == "adminToken"){   //check if either the request arrived from admin or the user wants to delete themself
            $user = Judge::find($id);
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
        if(auth()->user()->tokens->first()['name'] == 'userToken'){ // Stop users with simple userToken from accessing protected functions
            return response(
                ['result' => 'Bad Token. Unauthorized access of endpoint.'], 
                403
            );
        }

        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if(($tokenType == "judgeToken" && $tokenID == $id) OR $tokenType == "adminToken"){   //check if either the request arrived from admin or the user wants to delete themself
            JudgeController::logout($request);
            return Judge::destroy($id);
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
        return Judge::where('name', 'like', '%'.$name)->get();
    }
    public function searchCustom($type, $name){
        return Judge::where($type, 'like', '%'.$name)->get();
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
        $user = Judge::where('email', $fields['email'])->first();
        
        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return Response([
                'message' => 'Bad login credentials',
            ], 401);
        }

        $token = $user->createToken('judgeToken')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24);

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response([
            'user' => $user
        ])->withCookie($cookie);
    }

    public function judge(){
        return Auth::user();
    }
}
