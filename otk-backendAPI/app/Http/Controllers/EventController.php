<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BreedGroup;

class EventController extends Controller
{
    public function store(Request $request)
    {
        if(Auth::user()->user_type !== 2){
            return Response("Unauthorized acces.", 403);
        }
        
        $fields = $request->validate([
            'name' => 'required|string',
            'categoryId' => 'required|numeric',
            'selectedBreedGroupIds'   => 'required|array',
            'selectedBreedGroupIds.*' => 'numeric',
        ],[
            'name.required' => 'A név megadása kötelező!',
            'name.string' => 'A név nem megfelelő!',
            'categoryId.required' => 'A kategória megadása kötelező!',
            'categoryId.numeric' => 'A kategória nem megfelelő!',
            'selectedBreedGroupIds.required' => 'Válasszon ki legalább egy fajtacsoportot!',
            'selectedBreedGroupIds.array' => 'Hiba történt...',
            'selectedBreedGroupIds.numeric' => 'Hiba történt...',
        ]);

        //$now = date('Y-m-d H:i:s');
        $event = Event::create([
            'name' => $fields['name'],
            'category_id' => $fields['categoryId'],
            'active' => true,
        ]);
        $breedGroups = BreedGroup::find($fields['selectedBreedGroupIds']);
        $event->breedGroups()->attach($breedGroups);


        $response = [
            'event' => $event
        ];

        return response($response, 201);
    }

    public function getEvents(){
        return Event::all();
    }

    public function show($id)
    {
        $event = Event::find($id);
        $response = [
            'event' => $event,
            'breed_groups' => $event->breedGroups()->get(),
        ];
        return $response;
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
        if(Auth::user()->user_type !== 2){
            return Response("Unauthorized acces.", 403);
        }
        
        $request['active'] = true;
        $fields = $request->validate([
            'name' => 'string',
            'category_id' => 'required|numeric'
        ],
        [
            'name.string' => 'Hibás név!',
            'category_id.numeric' => 'Hibás Kategória!',
            'category_id.required' => 'A kategória megadása kötelező!',
        ]);
        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if(($tokenType == "adminToken")){   //check if the request arrived from the admin 
            $event = Event::find($id);
            $event->update($request->all());
            return $event;
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    public function destroy($id)
    {
        if(Auth::user()->user_type !== 2){
            return Response("Unauthorized acces.", 403);
        }
            $tokenType = auth()->user()->tokens->first()['name'];
            $tokenID = auth()->user()->tokens->first()['tokenable_id'];
            if($tokenType == "adminToken"){   //check if the request arrived from admin
                return Event::destroy($id);
            }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }
}
