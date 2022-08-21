<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function store(Request $request)
    {
        if(Auth::user()->user_type !== 2){
            return Response("Unauthorized acces.", 403);
        }
        
        $fields = $request->validate([
            'name' => 'required|string',
        ],[
            'name.required' => 'A név megadása kötelező!'
        ]);

        //$now = date('Y-m-d H:i:s');
        $event = Event::create([
            'name' => $fields['name'],
        ]);

        $response = [
            'event' => $event
        ];

        return response($response, 201);
    }

    public function getEvents(){
        if(Auth::user()->user_type !== 2){
            return Response("Unauthorized acces.", 403);
        }

        return Event::all();
    }

    public function show($id)
    {
        return Event::find($id);
    }
}
