<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exhibition;
use Illuminate\Support\Facades\DB;

class ExhibitionController extends Controller
{
    public function getAll()
    {
        return Exhibition::all();
    }
    public function getExhibitionById(Request $request)
    {
        $exhibition = Exhibition::find($request->exhibition_id);

        $categories = DB::table('event_categories')
            ->join('categories', 'categories.id', '=', 'event_categories.category_id')
            ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
            ->where('exhibition_id', $request->exhibition_id)
            ->select(
                'event_categories.*',
                'categories.type as categoryType',
                'hobby_categories.type as hobbyCategoryType',
            )
            ->get();

        return response([
            'exhibition' => $exhibition,
            'categories' => $categories,
        ]);
    }

    public function addExhibitionToHomePage(Request $request)
    {
        $fields = $request->validate([
            'exhibition_id' => 'required|numeric',
            'added_to_homepage' => 'required|boolean',
        ]);

        $exhibition = Exhibition::find($fields['exhibition_id']);
        $exhibition->update(['added_to_homepage' => $fields['added_to_homepage']]);

        return $exhibition->added_to_homepage;
    }

    public function getLoadedExhibitionWithRings()
    {
        $exhibition = DB::table('exhibitions')
            ->where('added_to_homepage', true)->get();

        if(!count($exhibition)){
            return '';
        } else {
            $exhibition = $exhibition[0];
        }


        $exhibition = Exhibition::find($exhibition->id);

        $rings = $exhibition->rings()->get();
        foreach ($rings as $key => $ring) {
            $ring->actualDog = [];
            $ring->actualDog = $ring->registeredDogs()->where('selected', true)
                ->join('event_categories', 'event_categories.id', '=', 'registered_dogs.event_category_id')
                ->join('dog_judgings', 'dog_judgings.dog_id', '=', 'registered_dogs.dog_id')
                ->join('categories', 'categories.id', '=', 'event_categories.category_id')
                ->join('breeds', 'breeds.id', '=', 'dog_judgings.breed_id')
                ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
                ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
                ->select(
                    'registered_dogs.start_number',
                    'registered_dogs.id',
                    'categories.type as categoryType',
                    'hobby_categories.type as hobbyCategoryType',
                    'dog_classes.type as classType',
                    'breeds.name as breedName',
                    'dog_judgings.gender',
                )->get();
        }

        return $rings;
    }
}
