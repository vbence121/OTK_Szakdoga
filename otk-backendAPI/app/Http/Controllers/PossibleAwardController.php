<?php

namespace App\Http\Controllers;

use App\Models\DogClass;
use App\Models\RegisteredDog;
use Illuminate\Http\Request;

class PossibleAwardController extends Controller
{
    public function getPossibleAwardsForDog(Request $request) {

        $fields = $request->validate([
            'registered_dog_id' => 'required|numeric',
        ]);

        $dog = RegisteredDog::find($fields['registered_dog_id']);

        $possibleAwards = DogClass::find($dog->dog_class_id)->PossibleAward()->get();

        return [
            'possibleAwards' => $possibleAwards,
            'hasAward' => $dog->award,
        ];
    }

    public function setAwardForDog(Request $request) {

        $fields = $request->validate([
            'award_id' => 'required|numeric',
            'registered_dog_id' => 'required|numeric',
        ]);

        $dog = RegisteredDog::find($fields['registered_dog_id']);

        $dog->update([
            'award' => $request['award_id'],
        ]);

        return $dog;
    }
}
