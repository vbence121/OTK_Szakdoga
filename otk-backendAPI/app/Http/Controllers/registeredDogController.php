<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegisteredDog;
use Illuminate\Support\Facades\DB;

class registeredDogController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'dog_id' => 'required|numeric',
            'event_id' => 'required|numeric',
        ]);

        //$now = date('Y-m-d H:i:s');
        $registeredDog = RegisteredDog::create([
            'dog_id' => $fields['dog_id'],
            'event_id' => $fields['event_id'],
            'user_id' => Auth::user()->id,
            'approved' => 0,
            'paid' => 0,
        ]);

        $response = [
            'registeredDog' => $registeredDog
        ];

        return response($response, 201);
    }

    public function getRegisteredDogsForActiveEvents()
    {
        $ActiveEvents = DB::table('events')->where('active', 1)->get();

        for ($i = 0; $i < count($ActiveEvents); $i++) {
            $registeredDogs = DB::table('registered_dogs')->where('event_id', '=', $ActiveEvents[$i]->id)->get();
            //return $registeredDogs;
            for($j = 0; $j < count($registeredDogs); $j++){
                $ActiveEvents[$i]->registeredDogs[] = DB::table('dogs')->where('id', '=', $registeredDogs[$j]->dog_id)->get()[0];
            }
        }

        return $ActiveEvents;
    }
}
