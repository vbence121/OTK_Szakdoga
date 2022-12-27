<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use App\Models\DogJudging;
use App\Models\EventCategory;
use App\Models\File;
use App\Models\RegisteredDog;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DogJudgingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DogJudging::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Dog $dog, EventCategory $event)
    {
        $dj = DogJudging::create([
            'name' => $dog['name'],
            'hobby' => $dog['hobby'],
            'gender' => $dog['gender'],
            'birthdate' => $dog['birthdate'],
            'user_id' => $dog['user_id'],
            'dog_id' => $dog['id'],
            'breederName' => $dog['breederName'],
            'motherName' => $dog['motherName'],
            'fatherName' => $dog['fatherName'],
            'breed_id' => $dog['breed_id'],
            'registerSernum' => $dog['registerSernum'],
            'herd_book_type_id' => $dog['herd_book_type_id'],
            'status' => 'approved',   // approved/declined/paid
            'event_category_id' => $event['id'], 
            'result' => '', // result of judging event
        ]);

        return $dj->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dog = DogJudging::find($id);
        if ($dog) {
            $breed = DB::table('breeds')->where('id', '=', $dog->breed_id)->get();
            $herdBookName = DB::table('herd_book_types')->where('id', '=', $dog->herd_book_type_id)->get();
            $dog->breed = $breed[0]->name;
            $dog->herdBookName = $herdBookName[0]->type;
        }

        return response([
            'dog' => $dog,
            'files' => $dog->files()->get(),
        ]);
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
        $fields = $request->validate(
            [
                'name' => 'string',
                'hobby' => 'boolean',
                'gender' => 'string',
                'birthdate' => 'date',
                'breederName' => 'string',
                //'description' => 'string|nullable',
                'motherName' => 'string|nullable',
                'fatherName' => 'string|nullable',
                'breed_id' => 'required|numeric',
                'registerSernum' => 'string|unique:dogs',
                'herd_book_type_id' => 'required|numeric',
                'status' => 'string',   // approved/declined/paid
                'event_id' => 'string', 
                'result' => 'string|nullable',
            ],
        );

        $tokenType = auth()->user()->tokens->first()['name'];
        //$tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if ($tokenType == "adminToken") {   //check if the request arrived from the user 
            $dog = DogJudging::find($id);
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
        $tokenType = auth()->user()->tokens->first()['name'];
        //$tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if ($tokenType == "adminToken") {   //check if either the request arrived from admin or the user
                return Dog::destroy($id);
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }
}
