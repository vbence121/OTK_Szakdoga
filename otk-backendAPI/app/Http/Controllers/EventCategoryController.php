<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HobbyCategory;
use App\Models\BreedGroup;
use App\Models\Exhibition;
use App\Models\HerdBookType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventCategoryController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->user_type !== 2) {
            return Response("Unauthorized acces.", 403);
        }

        $fields = $request->validate([
            'name' => 'required|string',
            'entry_deadline' => 'required|date',
            'selectedCategoryIds'   => 'required|array',
            'selectedCategoryIds.*' => 'numeric',
            'eventDate' => 'required|date',
        ], [
            'name.required' => 'A név megadása kötelező!',
            'name.string' => 'A név nem megfelelő!',
            'selectedCategoryIds.required' => 'Válasszon ki legalább egy kategóriát!',
            'selectedCategoryIds.array' => 'Hiba történt...',
            'selectedCategoryIds.numeric' => 'Hiba történt...',
            'eventDate.required' => 'A dátum megadása kötelező!',
        ]);

        $exhibition = Exhibition::create([
            'name' => $fields['name'],
            'active' => true,
            'date' => $fields['eventDate'],
            'entry_deadline' => $fields['entry_deadline'],
        ]);

        foreach($fields['selectedCategoryIds'] as $key => $category_id){
            if($category_id === 4){
                $hobbyCategories = HobbyCategory::all();
                foreach ($hobbyCategories as $key => $hobbyCategory) {
                    $breedGroups = [];
                    if($hobbyCategory->id === 1){
                        $breedGroups = BreedGroup::find([1,2,3,4,5,6,7,8,9,10]);
                    }
                    else if($hobbyCategory->id === 2){
                        $breedGroups = BreedGroup::find([1,2,3,4,5,6,7,8,9,10,11]);
                    }
                    else if($hobbyCategory->id === 3){
                        $breedGroups = BreedGroup::find([11]);
                    }
                    $event = EventCategory::create([
                        'category_id' => $category_id,
                        'hobby_category_id' => $hobbyCategory->id,
                        'exhibition_id' => $exhibition->id,
                    ]);
                    $event->breedGroups()->attach($breedGroups);
                    $this->attachHerdBooks($category_id, $event);
                }
            }
            else if($category_id === 1){
                $breedGroups = BreedGroup::find([1,2,3,4,5,6,7,8,9,10]);
                $event = EventCategory::create([
                    'category_id' => $category_id,
                    'exhibition_id' => $exhibition->id,
                ]);
                $event->breedGroups()->attach($breedGroups);
                $this->attachHerdBooks($category_id, $event);
            }
            else if($category_id === 2){
                $breedGroups = BreedGroup::find([1,2,3,4,5,6,7,8,9,10,11]);
                $event = EventCategory::create([
                    'category_id' => $category_id,
                    'exhibition_id' => $exhibition->id,
                ]);
                $event->breedGroups()->attach($breedGroups);
                $this->attachHerdBooks($category_id, $event);
            }
            else if($category_id === 3){
                $breedGroups = BreedGroup::find([11]);
                $event = EventCategory::create([
                    'category_id' => $category_id,
                    'exhibition_id' => $exhibition->id,
                ]);
                $event->breedGroups()->attach($breedGroups);
                $this->attachHerdBooks($category_id, $event);
            }
            else if($category_id === 5){
                $breedGroups = BreedGroup::find([12]);
                $event = EventCategory::create([
                    'category_id' => $category_id,
                    'exhibition_id' => $exhibition->id,
                ]);
                $event->breedGroups()->attach($breedGroups);
                $this->attachHerdBooks($category_id, $event);
            }
        }

        return response('success', 201);
    }

    public function getEventCategories()
    {
        return DB::table('event_categories')
        ->join('exhibitions', 'exhibitions.id', '=', 'event_categories.exhibition_id')
        ->where('active', '1')
        ->join('categories', 'categories.id', '=', 'event_categories.category_id')
        ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
        ->select(
            'event_categories.*',
            'categories.type as categoryType',
            'hobby_categories.type as hobbyCategoryType',
            'exhibitions.name as name',
            'exhibitions.date as date',
        )
        ->get();
    }

    public function getActiveEventsWithDeadlines() 
    {
        return DB::table('event_categories')
        ->join('exhibitions', 'exhibitions.id', '=', 'event_categories.exhibition_id')
        ->where('active', '1')
        ->whereDate('entry_deadline', '>=', Carbon::now()->toDateString())
        ->join('categories', 'categories.id', '=', 'event_categories.category_id')
        ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
        ->select(
            'event_categories.*',
            'categories.type as categoryType',
            'hobby_categories.type as hobbyCategoryType',
            'exhibitions.name',
            'exhibitions.entry_deadline',
        )
        ->get();
    }

    public function show($id)
    {
        $event = DB::table('event_categories')
            ->where('event_categories.id', $id)
            ->join('exhibitions', 'exhibitions.id', '=', 'event_categories.exhibition_id')
            ->join('categories', 'categories.id', '=', 'event_categories.category_id')
            ->leftJoin('hobby_categories', 'hobby_categories.category_id', '=', 'categories.id')
            ->select(
                'event_categories.*',
                'categories.type as categoryType',
                'hobby_categories.type as hobbyCategoryType',
                'exhibitions.name as name',
                'exhibitions.date',
                'exhibitions.entry_deadline',
            )
            ->get()[0];
        $ev = EventCategory::find($id);
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
            $event = EventCategory::find($id);
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
            return EventCategory::destroy($id);
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    public function getFinalDogs($event_category_id)
    {
        $breedGroupTypes = EventCategory::find($event_category_id)->breedGroups()->get();
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
            ->where('event_category_id', '=', $event_category_id)
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

    private function attachHerdBooks($category_id, $event){
        $herdBooks = [];
        if($category_id === 1){
            $herdBooks[] = 1;
        }
        else if($category_id === 2){
            $herdBooks[] = 1;
            $herdBooks[] = 2;
        }
        else if($category_id === 3){
            $herdBooks[] = 2;
        }
        else if($category_id === 4){
            $herdBooks[] = 3;
        }
        else if($category_id === 5){
            $herdBooks[] = 3;
        }

        $herdBooks = HerdBookType::find($herdBooks);
        
        $event->herdBookTypes()->attach($herdBooks);
    }
}
