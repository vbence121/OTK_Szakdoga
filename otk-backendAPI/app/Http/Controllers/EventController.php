<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BreedGroup;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->user_type !== 2) {
            return Response("Unauthorized acces.", 403);
        }

        $fields = $request->validate([
            'name' => 'required|string',
            'categoryId' => 'required|numeric',
            'selectedBreedGroupIds'   => 'required|array',
            'selectedBreedGroupIds.*' => 'numeric',
            'eventDate' => 'required|date',
        ], [
            'name.required' => 'A név megadása kötelező!',
            'name.string' => 'A név nem megfelelő!',
            'categoryId.required' => 'A kategória megadása kötelező!',
            'categoryId.numeric' => 'A kategória nem megfelelő!',
            'selectedBreedGroupIds.required' => 'Válasszon ki legalább egy fajtacsoportot!',
            'selectedBreedGroupIds.array' => 'Hiba történt...',
            'selectedBreedGroupIds.numeric' => 'Hiba történt...',
            'eventDate.required' => 'A dátum megadása kötelező!',
        ]);

        //$now = date('Y-m-d H:i:s');
        $event = Event::create([
            'name' => $fields['name'],
            'category_id' => $fields['categoryId'],
            'active' => true,
            'date' => $fields['eventDate'],
        ]);
        $breedGroups = BreedGroup::find($fields['selectedBreedGroupIds']);
        $event->breedGroups()->attach($breedGroups);


        $response = [
            'event' => $event
        ];

        return response($response, 201);
    }

    public function getEvents()
    {
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
        if (Auth::user()->user_type !== 2) {
            return Response("Unauthorized acces.", 403);
        }

        $request['active'] = true;
        $fields = $request->validate(
            [
                'name' => 'string',
                'category_id' => 'required|numeric'
            ],
            [
                'name.string' => 'Hibás név!',
                'category_id.numeric' => 'Hibás Kategória!',
                'category_id.required' => 'A kategória megadása kötelező!',
            ]
        );
        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if (($tokenType == "adminToken")) {   //check if the request arrived from the admin 
            $event = Event::find($id);
            $event->update($request->all());
            return $event;
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    public function destroy($id)
    {
        if (Auth::user()->user_type !== 2) {
            return Response("Unauthorized acces.", 403);
        }
        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if ($tokenType == "adminToken") {   //check if the request arrived from admin
            return Event::destroy($id);
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    public function getFinalDogs($event_id)
    {
        $breedGroupTypes = Event::find($event_id)->breedGroups()->get();
        $breeds = [];
        foreach($breedGroupTypes as $key => $group){
            $breeds[] = DB::table('breeds')->where('breed_group_id', '=', $group->id)->get();
        }

        $registeredDogsForEvent = DB::table('registered_dogs')
            ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
            ->join('breeds', 'breeds.id', '=', 'dogs.breed_id')
            ->join('dog_classes', 'registered_dogs.dog_class_id', '=', 'dog_classes.id')
            ->leftJoin('breed_groups', 'breed_groups.id', '=', 'breeds.breed_group_id')
            ->where('event_id', '=', $event_id)
            ->where('status', 'paid')
            ->select(
                'breeds.name as breedName',
                'dogs.name',
                'dogs.id',
                'dog_classes.type',
                'breed_groups.name as BreedGroupName',
                'breed_groups.id as breed_group_id',
                'dogs.breed_id',
                'registered_dogs.dog_class_id',
            )
            ->get();
        
        return [
            'dogsForEvent' => $registeredDogsForEvent,
            'breedGroups' => $breedGroupTypes,
            'breeds' => $breeds,
            'dog_classes' => DB::table('dog_classes')->get(),
        ];
    }
}
