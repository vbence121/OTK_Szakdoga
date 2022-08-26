<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegisteredDog;

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
}
