<?php

namespace App\Http\Controllers;

use App\Models\ReportedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ReportedUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReportedUser::all();
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
            'user_id' => 'required|string',
            'reason' => 'string',
            'decision' => 'string|nullable',
            'admin_id' => 'string|nullable', // to store the id of the deciding admin (nullable)
        ]);
        

        $user = ReportedUser::create([
            'user_id' => $fields['user_id'],
            'reason' => $fields['reason'],
            'decision' => $fields['decision'],
            'admin_id' => null,
        ]);

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
        return ReportedUser::find($id);
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
            'user_id' => 'string',
            'reason' => 'string',
            'decision' => 'string',
            'admin_id' => 'string'
        ]);

        $user = ReportedUser::find($request['id']);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        if((auth()->user()->tokens->first()['name'] != 'adminToken')){  // Stop users withouth adminToken from accessing protected functions
            return response(
                ['result' => 'Bad Token. Unauthorized access of endpoint'], 
                403
            );
        }
        
        return ReportedUser::destroy($request['user_id']);
    }

    /**
     * Search for User based on user_id
     * 
     * @param str $uID
     * @return \Illuminate\Http\Response
     */
    public function search($uID){
        return ReportedUser::where('user_id', 'like', '%'.$uID)->get();
    }
}
