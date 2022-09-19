<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegisteredDog;
use App\Models\Catalogue;
use App\Models\EventCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegisteredDogController extends Controller
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
            'event_category_id' => 'required|numeric',
            'dog_class_id' => 'required|numeric',
        ]);

        //$now = date('Y-m-d H:i:s');
        $registeredDog = RegisteredDog::create([
            'dog_id' => $fields['dog_id'],
            'event_category_id' => $fields['event_category_id'],
            'user_id' => Auth::user()->id,
            'status' => 'pending',
            'dog_class_id' => $fields['dog_class_id'],
        ]);

        $response = [
            'registeredDog' => $registeredDog
        ];

        return response($response, 201);
    }

    public function getRegisteredDogsForActiveEvents()
    {
        if (Auth::user()->user_type === 3) {
            return Response("Unauthorized acces.", 403);
        }

        $ActiveEvents = DB::table('event_categories')
            ->join('exhibitions', 'exhibitions.id', '=', 'event_categories.exhibition_id')
            ->where('active', '1')
            ->join('categories', 'categories.id', '=', 'event_categories.category_id')
            ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
            ->select(
                'event_categories.*',
                'categories.type as categoryType',
                'hobby_categories.type as hobbyCategoryType',
                'exhibitions.name',
            )
            ->get();

        for ($i = 0; $i < count($ActiveEvents); $i++) {
            $registeredDogs = DB::table('registered_dogs')->where('event_category_id', '=', $ActiveEvents[$i]->id)->where('status', 'pending')->get();

            // kutyák hozzáadása az egyes eseményekhez
            for ($j = 0; $j < count($registeredDogs); $j++) {
                $ActiveEvents[$i]->registeredDogs[] = DB::table('registered_dogs')
                    ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
                    ->where('dogs.id', '=', $registeredDogs[$j]->dog_id)->get()[0];
            }
        }

        return $ActiveEvents;
    }

    public function getRegisteredDogForEvent($event_category_id, $dog_id)
    {
        if (Auth::user()->user_type === 3) {
            return Response("Unauthorized acces.", 403);
        }

        $dogs = DB::table('registered_dogs')
            ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
            ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
            ->join('breeds', 'breeds.id', '=', 'dogs.breed_id')
            ->where('event_category_id', '=', $event_category_id)
            ->where('registered_dogs.dog_id', '=', $dog_id)
            ->where('status', 'pending')
            ->select('breeds.name as breedName', 'dogs.name', 'dogs.id', 'dog_classes.type', 'registered_dogs.dog_class_id')
            ->get();


        return $dogs;
    }

    public function getRegisteredDogForEventById($event_category_id, $dog_id)
    {
        if (Auth::user()->user_type === 3) {
            return Response("Unauthorized acces.", 403);
        }

        $dogs = DB::table('registered_dogs')
            ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
            ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
            ->join('breeds', 'breeds.id', '=', 'dogs.breed_id')
            ->where('event_category_id', '=', $event_category_id)
            ->where('registered_dogs.dog_id', '=', $dog_id)
            ->select('breeds.name as breedName', 'dogs.name', 'dogs.id', 'dog_classes.type', 'registered_dogs.dog_class_id')
            ->get();


        return $dogs;
    }


    public function getRegisteredDogsForEvent($event_category_id)
    {
        if (Auth::user()->user_type === 3) {
            return Response("Unauthorized acces.", 403);
        }

        $dogs = DB::table('registered_dogs')
            ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
            ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
            ->join('breeds', 'breeds.id', '=', 'dogs.breed_id')
            ->where('event_category_id', '=', $event_category_id)
            ->where('status', 'pending')
            ->select('breeds.name as breedName', 'dogs.name', 'dogs.id', 'dog_classes.type', 'registered_dogs.dog_class_id')
            ->get();


        return $dogs;
    }

    public function getPaymentsForActiveEvents()
    {
        if (Auth::user()->user_type === 3) {
            return Response("Unauthorized acces.", 403);
        }

        $ActiveEvents = DB::table('event_categories')
            ->join('exhibitions', 'exhibitions.id', '=', 'event_categories.exhibition_id')
            ->where('active', '1')
            ->join('categories', 'categories.id', '=', 'event_categories.category_id')
            ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
            ->select(
                'event_categories.*',
                'categories.type as categoryType',
                'hobby_categories.type as hobbyCategoryType',
                'exhibitions.name'
            )
            ->get();

        for ($i = 0; $i < count($ActiveEvents); $i++) {
            $registeredDogs = DB::table('registered_dogs')->where('event_category_id', '=', $ActiveEvents[$i]->id)->where('status', 'payment_submitted')->get();

            // kutyák hozzáadása az egyes eseményekhez
            for ($j = 0; $j < count($registeredDogs); $j++) {
                $ActiveEvents[$i]->registeredDogs[] = DB::table('registered_dogs')
                    ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
                    ->where('dogs.id', '=', $registeredDogs[$j]->dog_id)->get()[0];
            }
        }

        return $ActiveEvents;
    }

    public function getPaymentsForActiveEvent($event_category_id)
    {
        if (Auth::user()->user_type === 3) {
            return Response("Unauthorized acces.", 403);
        }

        $dogs = DB::table('registered_dogs')
            ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
            ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
            ->join('breeds', 'breeds.id', '=', 'dogs.breed_id')
            ->where('event_category_id', '=', $event_category_id)
            ->where('status', 'payment_submitted')
            ->select(
                'breeds.name as breedName',
                'dogs.name',
                'dogs.id',
                'dog_classes.type',
                'registered_dogs.dog_class_id'
            )
            ->get();

        return $dogs;
    }

    public function getRegisteredDogsForUser()
    {
        if (Auth::user()->user_type === 3) {
            return Response("Unauthorized acces.", 403);
        }

        $user = Auth::user();

        $registeredDogsForUser = DB::table('registered_dogs')->where('user_id', $user->id)->get();

        for ($i = 0; $i < count($registeredDogsForUser); $i++) {
            $registeredDogsForUser[$i]->dog = DB::table('dogs')
                ->join('breeds', 'breeds.id', '=', 'dogs.breed_id')
                ->where('dogs.id', '=', $registeredDogsForUser[$i]->dog_id)
                ->select('breeds.name as breedName', 'dogs.*')
                ->get()[0];
            $registeredDogsForUser[$i]->event = DB::table('event_categories')
                ->where('event_categories.id', '=', $registeredDogsForUser[$i]->event_category_id)
                ->join('exhibitions', 'exhibitions.id', '=', 'event_categories.exhibition_id')
                ->select('exhibitions.name')
                ->get()[0];
        }

        return $registeredDogsForUser;
    }

    public function updateStatus(Request $request)
    {
        if (Auth::user()->user_type === 3) {
            return Response("Unauthorized acces.", 403);
        }

        $fields = $request->validate([
            'status' => [
                'required',
                'string',
                Rule::in(['pending', 'declined', 'approved', 'paid', 'payment_declined', 'payment_submitted']),
            ],

            'dog_id' => [
                'required',
                'numeric',
            ],
            'event_category_id' => [
                'required',
                'numeric',
            ],
            'declined_reason' => [
                'string',
                'nullable',
            ],
        ]);

        $updated = RegisteredDog::where([
            'dog_id' => $request['dog_id'],
            'event_category_id' => $request['event_category_id'],
        ]);

        $updated->update([
            'status' => $request['status'],
            'declined_reason' => $request['declined_reason']
        ]);
        return Response(['result' => $updated]);
    }

    public function generateCatalogue(Request $request)
    {
        if (Auth::user()->user_type !== 2) {
            return Response("Unauthorized acces.", 403);
        }

        $fields = $request->validate([
            'name' => 'required|string',
            'selectedExhibitionId'   => 'required|numeric',
        ], [
            'name.required' => 'A név megadása kötelező!',
            'name.string' => 'A név nem megfelelő!',
            'name.unique' => 'Ez a név foglalt!',
            'selectedExhibitionId.required' => 'Válassza ki a kiállítást!',
            'selectedExhibitionId.numeric' => 'Hiba történt...',
        ]);

        $catalogue = Catalogue::create([
            'name' => $fields['name'],
            'exhibition_id' => $fields['selectedExhibitionId']
        ]);

        $relatedEventCategories = DB::table('event_categories')
        ->where('exhibition_id', $catalogue->exhibition_id)->get();

        $relatedEventCategoryIds = [];
        foreach ($relatedEventCategories as $key => $event_category) {
            $eachEvent = EventCategory::find($event_category->id);
            $eachEvent->catalogue_id = $catalogue->id;
            $eachEvent->save();
            $relatedEventCategoryIds[] = $event_category->id;
        }
        $registeredDogs = DB::table('registered_dogs')
        ->whereIn('event_category_id', $relatedEventCategoryIds)
        ->where('status', 'paid')
        ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
        ->join('breeds', 'dogs.breed_id', '=', 'breeds.id')
        ->join('breed_groups', 'breed_groups.id', '=', 'breeds.breed_group_id')
        ->select('registered_dogs.*', 'dogs.breed_id', 'breeds.breed_group_id')
        ->orderBy('registered_dogs.event_category_id', 'ASC')
        ->orderBy('breed_groups.name', 'ASC')
        ->orderBy('breeds.name', 'ASC')
        ->get();
        
        //rajtszám kiosztása 
        for ($i = 0; $i < count($registeredDogs); $i++) {
            $dog = RegisteredDog::find($registeredDogs[$i]->id);
            $dog->start_number = $i + 1;
            $dog->save();
        }
        
        //üres katalógusok törlése 
        $catalouges = Catalogue::all();
        foreach ($catalouges as $key => $catalogue) {
            $relatedEvents = $catalogue->events()->get();
            if (!count($relatedEvents)) {
                Catalogue::destroy($catalogue->id);
            }
        }
        return 'asd';

        return 'success';
    }
}
