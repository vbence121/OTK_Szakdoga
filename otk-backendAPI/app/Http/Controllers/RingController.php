<?php

namespace App\Http\Controllers;

use App\Events\DogChange;
use Illuminate\Http\Request;
use App\Models\Ring;
use App\Models\Exhibition;
use App\Models\RegisteredDog;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class RingController extends Controller
{   
    public function broadcastWith(Request $request) 
    {
        $fields = $request->validate([
            'ring_id' => 'required|numeric',
            'move_to_next' => 'required|boolean',
            'unselect' => 'nullable|boolean',
        ]);

        $dogs = $this->getDogsForRingById($fields['ring_id']);
        $dogs->toArray();
        $selectedDog = [];
        
        if($fields['unselect']){
            for ($i=0; $i < count($dogs); $i++) {
                if($dogs[$i]->selected){
                    $dogToUnselect = RegisteredDog::find($dogs[$i]->id);
                    $dogToUnselect->update([ 'selected' => false ]);
                }
            }
        }
        else if($fields['move_to_next']){
            for ($i=0; $i < count($dogs); $i++) { 
                if($dogs[$i]->selected){
                    $dogToUnselect = RegisteredDog::find($dogs[$i]->id);
                    $dogToUnselect->update([ 'selected' => false ]);
                    if($i + 1 < count($dogs)){
                        $newSelectedDog = RegisteredDog::find($dogs[$i + 1]->id);
                        $newSelectedDog->update([ 'selected' => true ]);
                        $selectedDog[] = $dogs[$i + 1];
                        break;
                    }
                }
    
                if($i === count($dogs) - 1){
                    $dogToUnselect = RegisteredDog::find($dogs[$i]->id);
                    $dogToUnselect->update([ 'selected' => false ]);
                }
            }
    
            if(count($selectedDog) < 1 && count($dogs) > 0){
                $newSelectedDog = RegisteredDog::find($dogs[0]->id);
                $newSelectedDog->update([ 'selected' => true ]);
                $selectedDog[] = $dogs[0];
            }
        } else {
            for ($i=0; $i < count($dogs); $i++) { 
                if($dogs[$i]->selected){
                    $dogToUnselect = RegisteredDog::find($dogs[$i]->id);
                    $dogToUnselect->update([ 'selected' => false ]);
                    if($i - 1 > -1){
                        $newSelectedDog = RegisteredDog::find($dogs[$i - 1]->id);
                        $newSelectedDog->update([ 'selected' => true ]);
                        $selectedDog[] = $dogs[$i - 1];
                        break;
                    } else {
                        $newSelectedDog = RegisteredDog::find($dogs[count($dogs) - 1]->id);
                        $newSelectedDog->update([ 'selected' => true ]);
                        $selectedDog[] = $dogs[count($dogs) - 1];
                    }
                }
            }
        }

        broadcast(new DogChange($selectedDog, $fields['ring_id']));
    }

    public function create(Request $request) {

        $fields = $request->validate([
            'exhibition_id' => 'required|numeric',
            'name' => 'required|string',
        ],
        [
            'exhibition_id.required' => 'Hiba történt!',
            'exhibition_id.numeric' => 'Hiba történt!',
        ]);

        $ring = Ring::create([
            'exhibition_id' => $fields['exhibition_id'],
            'name' => $fields['name'],
        ]);

        return $ring;
    }

    public function getRingsByExhibitionId(Request $request) {

        $fields = $request->validate([
            'exhibition_id' => 'required|numeric',
        ],
        [
            'exhibition_id.required' => 'Hiba történt!',
            'exhibition_id.numeric' => 'Hiba történt!',
        ]);

        $exhibition = Exhibition::find($fields['exhibition_id']);

        $rings = $exhibition->rings()->get();
        foreach ($rings as $key => $ring) {
            $ring->registeredDogs = [];
            $ring->registeredDogs = $ring->registeredDogs()->get();
        }

        return $rings;
    }

    public function getRingById($ring_id) {

        return Ring::find($ring_id);
    }
    public function getSelectedDogInRing(Request $request) {

        $fields = $request->validate([
            'ring_id' => 'required|numeric',
        ]);

        $ring = Ring::find($fields['ring_id']);
        $selectedDog = $ring->registeredDogs()->where('selected', true)->get();

        if(count($selectedDog)){
            $selectedDog = $selectedDog[0];
            return DB::table('registered_dogs')
            ->join('registered_dog_ring', 'registered_dog_ring.registered_dog_id', '=', 'registered_dogs.id')
            ->join('rings', 'registered_dog_ring.ring_id', '=', 'rings.id')
            ->where('registered_dogs.id', '=', $selectedDog->id)
            ->join('event_categories', 'event_categories.id', '=', 'registered_dogs.event_category_id')
            ->join('dog_judgings', 'dog_judgings.dog_id', '=', 'registered_dogs.dog_id')
            ->join('categories', 'categories.id', '=', 'event_categories.category_id')
            ->join('breeds', 'breeds.id', '=', 'dog_judgings.breed_id')
            ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
            ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
            ->select(
                'registered_dogs.start_number',
                'registered_dogs.id',
                'registered_dogs.selected',
                'categories.type as categoryType',
                'hobby_categories.type as hobbyCategoryType',
                'dog_classes.type as classType',
                'breeds.name as breedName',
                'dog_judgings.gender',
            )->orderBy('registered_dogs.start_number')
            ->get();
        } else {
            return [];
        }


    }

    public function getPossibleDogsForRing($exhibition_id, $ring_id){
        
        $alreadyAddedDogIds = DB::table('registered_dogs')
        ->join('registered_dog_ring', 'registered_dog_ring.registered_dog_id', '=', 'registered_dogs.id')
        ->select('registered_dog_ring.registered_dog_id')->get();

        $alreadyAddedIds = [];
        for ($i=0; $i < count($alreadyAddedDogIds) ; $i++) { 
            $alreadyAddedIds[$i] = $alreadyAddedDogIds[$i]->registered_dog_id;
        }

        return DB::table('registered_dogs')
        ->join('event_categories', 'event_categories.id', '=', 'registered_dogs.event_category_id')
        ->where('event_categories.exhibition_id', $exhibition_id)
        ->join('dog_judgings', 'dog_judgings.dog_id', '=', 'registered_dogs.dog_id')
        ->join('categories', 'categories.id', '=', 'event_categories.category_id')
        ->join('breeds', 'breeds.id', '=', 'dog_judgings.breed_id')
        ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
        ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
        ->whereNotIn('registered_dogs.id', $alreadyAddedIds)
        ->select(
            'registered_dogs.start_number',
            'registered_dogs.id',
            'categories.type as categoryType',
            'hobby_categories.type as hobbyCategoryType',
            'dog_classes.type as classType',
            'breeds.name as breedName',
            'dog_judgings.gender',
        )->orderBy('registered_dogs.start_number')
        ->get();
    }

    public function addSelectedDogsToRing(Request $request)
    {
        $fields = $request->validate([
            'exhibition_id' => 'required|numeric',
            'dog_ids'   => 'required|array',
            'dog_ids.*' => 'numeric',
            'ring_id' => 'required|numeric',
        ],
        [
            'exhibition_id.required' => 'Hiba történt!',
            'exhibition_id.numeric' => 'Hiba történt!',
        ]);

        $ring = Ring::find($fields['ring_id']);
        $ring->registeredDogs()->attach(RegisteredDog::find($fields['dog_ids']));

        return 'success';
    }

    public function getDogsForRingById($ring_id)
    {
        return DB::table('registered_dogs')
        ->join('registered_dog_ring', 'registered_dog_ring.registered_dog_id', '=', 'registered_dogs.id')
        ->join('rings', 'registered_dog_ring.ring_id', '=', 'rings.id')
        ->where('rings.id', '=', $ring_id)
        ->join('event_categories', 'event_categories.id', '=', 'registered_dogs.event_category_id')
        ->join('dog_judgings', 'dog_judgings.dog_id', '=', 'registered_dogs.dog_id')
        ->join('categories', 'categories.id', '=', 'event_categories.category_id')
        ->join('breeds', 'breeds.id', '=', 'dog_judgings.breed_id')
        ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
        ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
        ->select(
            'registered_dogs.start_number',
            'registered_dogs.id',
            'registered_dogs.selected',
            'categories.type as categoryType',
            'hobby_categories.type as hobbyCategoryType',
            'dog_classes.type as classType',
            'breeds.name as breedName',
            'dog_judgings.gender',
        )->orderBy('registered_dogs.start_number')
        ->get();
    }

    public function deleteRingById($ring_id) {

        return Ring::where('id', $ring_id)->firstorfail()->delete();
    }

    public function removeDogsFromRing(Request $request) {

        $fields = $request->validate([
            'dog_ids'   => 'required|array',
            'dog_ids.*' => 'numeric',
            'ring_id' => 'required|numeric',
        ],
        [
            'exhibition_id.required' => 'Hiba történt!',
            'exhibition_id.numeric' => 'Hiba történt!',
        ]);

        $ring = Ring::find($fields['ring_id']);
        $ring->registeredDogs()->detach(RegisteredDog::find($fields['dog_ids']));
    }
}
