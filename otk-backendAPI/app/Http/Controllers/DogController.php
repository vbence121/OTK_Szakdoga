<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class DogController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dog::all();
    }

    public function showuserdogs()
    {
        return Auth::user()->dogs()->get();
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
            'name' => 'required|string',
            'breed' => 'required|string',
            'hobby' => 'required|boolean',
            'birthdate' => 'required|date',
            'breederName' => 'required|string',
            'description' => 'string|nullable',
            'motherName' => 'string|nullable',
            'fatherName' => 'string|nullable',
            'category' => 'required|string',
            'registerSernum' => 'required|string|unique:dogs',
            'registerType' => 'required|string',
        ],
        [
            'registerSernum.unique' => 'Ez a törzskönyvszám már regisztálva volt!',            
        ]);

        //$now = date('Y-m-d H:i:s');
        $dog = Dog::create([
            'name' => $fields['name'],
            'breed' => $fields['breed'],
            'hobby' => $fields['hobby'],
            'birthdate' => $fields['birthdate'],
            'user_id' => Auth::user()->id,
            'breederName' => $fields['breederName'],
            'description' => $fields['description'],
            'motherName' => $fields['motherName'],
            'fatherName' => $fields['fatherName'],
            'category' => $fields['category'],
            'registerSernum' => $fields['registerSernum'],
            'registerType' => $fields['registerType'],
        ]);

        $response = [
            'dog' => $dog
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
        return Dog::find($id);
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
        $fields = $request->validate([
            'name' => 'string',
            'breed' => 'string',
            'hobby' => 'boolean',
            'birthdate' => 'date',
            'breederName' => 'string',
            'description' => 'string|nullable',
            'motherName' => 'string|nullable',
            'fatherName' => 'string|nullable',
            'category' => 'string',
            'registerSernum' => 'string|unique:dogs',
            'registerType' => 'string',
        ],
        [
            'registerSernum.unique' => 'Ez a törzskönyvszám már regisztálva volt!',
        ]);
        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if(($tokenType == "adminToken" || $tokenID == Auth::user()->id)){   //check if the request arrived from the user 
            $dog = Dog::find($id);
            $dog->update($request->all());
            return $dog;
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->id === Dog::find($id)->user_id){
            $tokenType = auth()->user()->tokens->first()['name'];
            $tokenID = auth()->user()->tokens->first()['tokenable_id'];
            if($tokenType == "adminToken" OR $tokenID == Auth::user()->id){   //check if either the request arrived from admin or the user
                return Dog::destroy($id);
            }
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
        return Dog::where('name', 'like', '%'.$name)->get();
    }
    public function searchCustom($type, $name){
        return Admin::where($type, 'like', '%'.$name)->get();
    }
}
