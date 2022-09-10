<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegisteredDog;
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
            'event_id' => 'required|numeric',
            'dog_class_id' => 'required|numeric',
        ]);

        //$now = date('Y-m-d H:i:s');
        $registeredDog = RegisteredDog::create([
            'dog_id' => $fields['dog_id'],
            'event_id' => $fields['event_id'],
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

        $ActiveEvents = DB::table('events')->where('active', 1)->get();

        for ($i = 0; $i < count($ActiveEvents); $i++) {
            $registeredDogs = DB::table('registered_dogs')->where('event_id', '=', $ActiveEvents[$i]->id)->where('status', 'pending')->get();

            // kutyák hozzáadása az egyes eseményekhez
            for ($j = 0; $j < count($registeredDogs); $j++) {
                $ActiveEvents[$i]->registeredDogs[] = DB::table('registered_dogs')
                    ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
                    ->where('dogs.id', '=', $registeredDogs[$j]->dog_id)->get()[0];
            }
        }

        return $ActiveEvents;
    }

    public function getRegisteredDogsForEvent($event_id)
    {
        if (Auth::user()->user_type === 3) {
            return Response("Unauthorized acces.", 403);
        }

        $dogs = DB::table('registered_dogs')
                ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
                ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
                ->join('breeds', 'breeds.id', '=', 'dogs.breed_id')
                ->where('event_id', '=', $event_id)
                ->where('status', 'pending')
                ->select('breeds.name as breedName', 'dogs.name', 'dogs.id', 'dog_classes.type', 'registered_dogs.dog_class_id')
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
            $registeredDogsForUser[$i]->dog = DB::table('dogs')->where('id', '=', $registeredDogsForUser[$i]->dog_id)->get()[0];
            $registeredDogsForUser[$i]->event = DB::table('events')->where('id', '=', $registeredDogsForUser[$i]->event_id)->get()[0];
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
                Rule::in(['pending', 'declined', 'approved', 'paid']),
            ],

            'dog_id' => [
                'required',
                'numeric',
            ],
            'dog_class_id' => [
                'required',
                'numeric',
            ],
            'event_id' => [
                'required',
                'numeric',
            ],
            'declined_reason' => [
                'string',
                'nullable',
            ],
        ]);

        $updated = registeredDog::where([
            'dog_id' => $request['dog_id'],
            'event_id' => $request['event_id'],
            'dog_class_id' => $request['dog_class_id'],
        ]);

        $updated->update([
            'status' => $request['status'],
            'declined_reason' => $request['declined_reason']
        ]);
        return Response(['result' => $updated]);
    }
}
