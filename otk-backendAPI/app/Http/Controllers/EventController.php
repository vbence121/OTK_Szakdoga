<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BreedGroup;
use App\Models\HerdBookType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            'entry_deadline' => 'required|date',
            'selectedBreedGroupIds'   => 'required|array',
            'selectedBreedGroupIds.*' => 'numeric',
            'eventDate' => 'required|date',
            'hobby_category_id' => 'numeric',
        ], [
            'name.required' => 'A név megadása kötelező!',
            'name.string' => 'A név nem megfelelő!',
            'categoryId.required' => 'A kategória megadása kötelező!',
            'categoryId.numeric' => 'A kategória nem megfelelő!',
            'selectedBreedGroupIds.required' => 'Válasszon ki legalább egy fajtacsoportot!',
            'selectedBreedGroupIds.array' => 'Hiba történt...',
            'selectedBreedGroupIds.numeric' => 'Hiba történt...',
            'eventDate.required' => 'A dátum megadása kötelező!',
            'hobby_category_id.numeric' => 'Hiba történt...',
        ]);

        //$now = date('Y-m-d H:i:s');
        $event = Event::create([
            'name' => $fields['name'],
            'category_id' => $fields['categoryId'],
            'active' => true,
            'date' => $fields['eventDate'],
            'entry_deadline' => $fields['entry_deadline'],
            'hobby_category_id' => $fields['hobby_category_id'],
        ]);
        $breedGroups = BreedGroup::find($fields['selectedBreedGroupIds']);
        $event->breedGroups()->attach($breedGroups);

        $herdBooks = [];
        if($fields['categoryId'] === 1){
            $herdBooks[] = 1;
        }
        else if($fields['categoryId'] === 2){
            $herdBooks[] = 1;
            $herdBooks[] = 2;
        }
        else if($fields['categoryId'] === 3){
            $herdBooks[] = 2;
        }
        else if($fields['categoryId'] === 4){
            $herdBooks[] = 3;
        }
        else if($fields['categoryId'] === 5){
            $herdBooks[] = 3;
        }

        $herdBooks = HerdBookType::find($herdBooks);
        
        $event->herdBookTypes()->attach($herdBooks);

        $response = [
            'event' => $event
        ];

        return response($response, 201);
    }

    public function getEvents()
    {
        //return Event::all()->where('active', '1');
        return DB::table('events')
        ->where('active', '1')
        ->join('categories', 'categories.id', '=', 'events.category_id')
        ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'events.hobby_category_id')
        ->select(
            'events.*',
            'categories.type as categoryType',
            'hobby_categories.type as hobbyCategoryType'
        )
        ->get();
    }

    public function getActiveEventsWithDeadlines() 
    {
        return DB::table('events')
        ->whereDate('entry_deadline', '>=', Carbon::now()->toDateString())
        ->join('categories', 'categories.id', '=', 'events.category_id')
        ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'events.hobby_category_id')
        ->select(
            'events.*',
            'categories.type as categoryType',
            'hobby_categories.type as hobbyCategoryType'
        )
        ->get();
    }

    public function show($id)
    {
        $event = DB::table('events')
            ->where('events.id', $id)
            ->join('categories', 'categories.id', '=', 'events.category_id')
            ->leftJoin('hobby_categories', 'hobby_categories.category_id', '=', 'categories.id')
            ->select(
                'events.*',
                'categories.type as categoryType',
                'hobby_categories.type as hobbyCategoryType'
            )
            ->get()[0];
        $ev = Event::find($id);
        $response = [
            'event' => $event,
            'breed_groups' => $ev->breedGroups()->get(),
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
            ->join('users', 'users.id', '=', 'registered_dogs.user_id')
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
                'users.email'
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
