<?php

namespace App\Http\Controllers;

use App\Models\DogClass;
use App\Models\RegisteredDog;
use Illuminate\Http\Request;

class PossibleTitleController extends Controller
{
    public function getPossibleTitlesForDog(Request $request) {

        $fields = $request->validate([
            'registered_dog_id' => 'required|numeric',
        ]);

        $dog = RegisteredDog::find($fields['registered_dog_id']);

        $possibleTitle = DogClass::find($dog->dog_class_id)->PossibleTitle()->get();

        return [
            'possibleTitle' => $possibleTitle,
            'hasTitle' => $dog->title,
        ];
    }

    public function setTitleForDog(Request $request) {

        $fields = $request->validate([
            'title_id' => 'required|numeric',
            'registered_dog_id' => 'required|numeric',
        ]);

        $dog = RegisteredDog::find($fields['registered_dog_id']);

        $dog->update([
            'title' => $request['title_id'],
        ]);

        return $dog;
    }
}
