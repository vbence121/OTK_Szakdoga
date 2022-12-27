<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Event;
use App\Models\File;
use App\Models\RegisteredDog;
use App\Models\User;
use App\Models\Exhibition;
use App\Models\DogClass;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;
use Illuminate\Support\Facades\Response as FacadeResponse;
use ZipArchive;
use File as DefaultFile;
use DateTime;
use Illuminate\Validation\Rule;

class DogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dog::all();
    }

    public function showuserdogs()
    {
        $dogs = Auth::user()->dogs()->get();

        for ($i = 0; $i < count($dogs); $i++) {
            $breed = DB::table('breeds')->where('id', '=', $dogs[$i]->breed_id)->get();
            $dogs[$i]->breed = $breed[0]->name;
        }
        return $dogs;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate(
            [
                'name' => 'required|string',
                'hobby' => 'required|boolean',
                'gender' => [
                    'required',
                    'string',
                    Rule::in(['kan', 'szuka']),
                ],
                'birthdate' => 'required|date',
                'breederName' => 'required|string',
                'description' => 'string|nullable',
                'motherName' => 'string|nullable',
                'fatherName' => 'string|nullable',
                'breed_id' => 'required|numeric',
                'registerSernum' => 'nullable|string|unique:dogs',
                'herd_book_type_id' => 'required|numeric',
            ],
            [
                'registerSernum.unique' => 'Ez a törzskönyvszám már regisztálva volt!',
            ]
        );

        //$now = date('Y-m-d H:i:s');
        $dog = Dog::create([
            'name' => $fields['name'],
            'hobby' => $fields['hobby'],
            'gender' => $fields['gender'],
            'birthdate' => $fields['birthdate'],
            'user_id' => Auth::user()->id,
            'breederName' => $fields['breederName'],
            'description' => $fields['description'],
            'motherName' => $fields['motherName'],
            'fatherName' => $fields['fatherName'],
            'breed_id' => $fields['breed_id'],
            'registerSernum' => $fields['registerSernum'],
            'herd_book_type_id' => $fields['herd_book_type_id'],
        ]);

        $response = [
            'dog' => $dog
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dog = Dog::find($id);
        if ($dog) {
            $breed = DB::table('breeds')->where('id', '=', $dog->breed_id)->get();
            $herdBookName = DB::table('herd_book_types')->where('id', '=', $dog->herd_book_type_id)->get();
            $dog->breed = $breed[0]->name;
            $dog->herdBookName = $herdBookName[0]->type;
        }

        return response([
            'dog' => $dog,
            'files' => $dog->files()->get(),
        ]);
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
        $fields = $request->validate(
            [
                'name' => 'string',
                'hobby' => 'boolean',
                'birthdate' => 'date',
                'breederName' => 'string',
                'description' => 'string|nullable',
                'motherName' => 'string|nullable',
                'fatherName' => 'string|nullable',
                'breed_id' => 'required|numeric',
                'registerSernum' => 'string|unique:dogs',
                'herd_book_type_id' => 'required|numeric',
            ],
            [
                'registerSernum.unique' => 'Ez a törzskönyvszám már regisztálva volt!',
            ]
        );
        $tokenType = auth()->user()->tokens->first()['name'];
        $tokenID = auth()->user()->tokens->first()['tokenable_id'];
        if (($tokenType == "adminToken" || $tokenID == Auth::user()->id)) {   //check if the request arrived from the user 
            $dog = Dog::find($id);
            $dog->update($request->all());
            return $dog;
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->id === Dog::find($id)->user_id) {
            $tokenType = auth()->user()->tokens->first()['name'];
            $tokenID = auth()->user()->tokens->first()['tokenable_id'];
            if ($tokenType == "adminToken" or $tokenID == Auth::user()->id) {   //check if either the request arrived from admin or the user
                return Dog::destroy($id);
            }
        }
        return Response("Unauthorized acces. Token doesn't match provided ID.", 403);
    }

    /**
     * Search for Judge based on Name
     * 
     * @param str $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Dog::where('name', 'like', '%' . $name)->get();
    }
    public function searchCustom($type, $name)
    {
        return Dog::where($type, 'like', '%' . $name)->get();
    }

    public function uploadFile(Request $request, $dog_id)
    {
        // ha nem a saját kutyájához akar feltölteni
        $isUserHasTheDog = DB::table('dogs')->where('user_id', '=', Auth::user()->id)->where('id', $dog_id)->get();
        if (count($isUserHasTheDog) === 0) {
            return Response("Unauthorized acces.", 403);
        }

        $this->validate(
            $request,
            [
                'file' => 'required|mimes:jpg,png,jpeg,svg,pdf|max:20000',
                'name' => 'max:50',
            ],
            [
                'file.required' => 'Nincs fájl kiválasztva!',
                'file.mimes' => 'Rossz formátum!',
                'name.max' => 'A cím túl hosszú!',
            ]
        );

        $ext = pathinfo($request->file->getClientOriginalName(), PATHINFO_EXTENSION);
        $unique_name = substr(base_convert(time(), 10, 36) . md5(microtime()), 0, 16) . "." . $ext;
        $request->file->move(public_path('files'), $unique_name);

        File::create([
            'generated_name' => $unique_name,
            'name' => $request->file->getClientOriginalName(),
            'dog_id' => $dog_id,
        ]);

        return "success";
    }

    public function deleteFile($dog_id, $file_id){
        // ha nem a saját kutyájához akar hozzáférni más user
        if (Auth::user()->user_type === 1) {
            $isUserHasTheDog = DB::table('dogs')->where('user_id', '=', Auth::user()->id)->where('id', $dog_id)->get();
            if (count($isUserHasTheDog) === 0) {
                return Response("Unauthorized acces.", 403);
            }
            File::where('id', $file_id)->firstorfail()->delete();
            return "success";
        }

    }

    public function getUploadedFilesForDog($dog_id)
    {
        // ha nem a saját kutyájához akar hozzáférni más user
        if (Auth::user()->user_type === 1) {
            $isUserHasTheDog = DB::table('dogs')->where('user_id', '=', Auth::user()->id)->where('id', $dog_id)->get();
            if (count($isUserHasTheDog) === 0) {
                return Response("Unauthorized acces.", 403);
            }
            return DB::table('files')->where('dog_id', '=', $dog_id)->get();
        }
    }

    public function getPossibleDogsForEventEntry($event_category_id)
    {
        if (Auth::user()->user_type !== 1) {
            return Response("Unauthorized acces.", 403);
        }

        $event = EventCategory::find($event_category_id);
        $acceptedBreedGroups = $event->breedGroups()->get();
        $userDogs = Auth::user()->dogs()->get();
        // ha a kutya breedGroupja beletartozik az eseményen elfogadott breedGroupokba
        $possibleDogs = [];
        foreach ($userDogs as $key => $eachDog) {
            $breed = $eachDog->breed()->get();
            $eachDogsBreedGroup = $breed[0]->breedGroup()->get()[0];
            foreach ($acceptedBreedGroups as $key => $acceptedBreedGroup) {
                if ($eachDogsBreedGroup->id === $acceptedBreedGroup->id) {
                    $possibleDogs[] = $eachDog;
                    break;
                }
            }
        }

        // a szűrt kutyák fajta nevének hozzáadása, hogy ne kelljen még külön keresni
        for ($i = 0; $i < count($possibleDogs); $i++) {
            $breed = DB::table('breeds')->where('id', '=', $possibleDogs[$i]->breed_id)->get();
            $possibleDogs[$i]->breed = $breed[0]->name;
        }

        // ha hobby kiállítás van
        if($event->hobby_category_id){
            foreach($possibleDogs as $key => $dog) {
                if(!$dog->hobby){
                    unset($possibleDogs[$key]);
                }
            }
        }
        //ha a kutya hobby de a kategória nem hobby
        if(!$event->hobby_category_id){
            foreach($possibleDogs as $key => $dog) {
                if($dog->hobby){
                    unset($possibleDogs[$key]);
                }
            }
        }

        // ha nem megfelelő a törzskönyv kivesszük
        $acceptedHerdBookTypes = $event->herdBookTypes()->get();
        foreach($possibleDogs as $key => $dog) {
            $isAccepted = false;
            foreach($acceptedHerdBookTypes as $key => $type) {
                if($type->id === $dog->herd_book_type_id){
                    $isAccepted = true;
                    break;
                }
            }
            if(!$isAccepted) {
                unset($possibleDogs[$key]);
            }
        }

        return $possibleDogs;
    }

    public function getPossibleClassesForDogInEvent($event_category_id, $dog_id)
    {
        $selectedDogRecords = DB::table('registered_dogs')->where('dog_id', '=', $dog_id)->where('event_category_id', '=', $event_category_id)->get();
        $possibleClasses = DogClass::all();

        //ha az eseményre nevezve van a kutya, nem nevezhet többször.
        if(count($selectedDogRecords) > 0) return [];
        

        $selectedDog = Dog::find($dog_id);
        //$selectedEvent = Exhibition::find($event_category_id) 
        $selectedEvent = EventCategory::find($event_category_id)->exhibitions()->get()[0];
        $dogBirthdate = date('Y-m-d', strtotime($selectedDog->birthdate));
        $selectedEventDate = date('Y-m-d', strtotime($selectedEvent->date));
        // ha a kutya életkora a tartományon kívül esik, töröljük az osztályt a $possibleClasses-ból.
        foreach ($possibleClasses as $classKey => $class) {
            $range_start = date('Y-m-d', strtotime($selectedEventDate .'-' . $class->range_start . ' months'));
            $range_end = date('Y-m-d', strtotime($selectedEventDate .'-' . $class->range_end . ' months'));
            if(!($range_start > $dogBirthdate && $range_end <= $dogBirthdate)){
                unset($possibleClasses[$classKey]);
            }
        }

        return $possibleClasses;
    }
}
