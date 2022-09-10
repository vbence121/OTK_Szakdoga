<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Event;
use App\Models\File;
use App\Models\RegisteredDog;
use App\Models\User;
use App\Models\DogClass;
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
                'birthdate' => 'required|date',
                'breederName' => 'required|string',
                'description' => 'string|nullable',
                'motherName' => 'string|nullable',
                'fatherName' => 'string|nullable',
                'breed_id' => 'required|numeric',
                'registerSernum' => 'required|string|unique:dogs',
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
        if($dog){
            $breed = DB::table('breeds')->where('id', '=', $dog->breed_id)->get();
            $dog->breed = $breed[0]->name;
        }

        return response([
            'dog' => $dog,
            'files' =>$dog->files()->get(),
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
        return Admin::where($type, 'like', '%' . $name)->get();
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

    public function getUploadedFilesForDog($dog_id)
    {
        // ha nem a saját kutyájához akar hozzáférni más user
        if (Auth::user()->user_type === 1) {
            $isUserHasTheDog = DB::table('dogs')->where('user_id', '=', Auth::user()->id)->where('id', $dog_id)->get();
            if (count($isUserHasTheDog) === 0) {
                return Response("Unauthorized acces.", 403);
            }
        }
        return DB::table('files')->where('dog_id', '=', $dog_id)->get();
    }

    public function getPossibleDogsForEventEntry($event_id)
    {
        if (Auth::user()->user_type !== 1) {
            return Response("Unauthorized acces.", 403);
        }

        $event = Event::find($event_id);
        $acceptedBreedGroups = $event->breedGroups()->get();
        $userDogs = Auth::user()->dogs()->get();
        // ha a kutya breedGroupja beletartozik az eseményen elfogadott breedGroupokba
        $possibleDogs = [];
        foreach ($userDogs as $key => $eachDog) {
            $breed = $eachDog->breed()->get();
            $eachDogsBreedGroup = $breed[0]->breedGroup()->get()[0];
            foreach ($acceptedBreedGroups as $key => $acceptedBreedGroup) {
                if($eachDogsBreedGroup->id === $acceptedBreedGroup->id){
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
        return $possibleDogs;
    }

    public function getPossibleClassesForDogInEvent($event_id, $dog_id) 
    {
        $selectedDogRecords = DB::table('registered_dogs')->where('dog_id', '=', $dog_id)->where('event_id', '=', $event_id)->get();
        $possibleClasses = DogClass::all();

        //ha az osztályban nevezve van már a kutya, töröljük az osztályt a $dogClasses-ból.
        foreach ($selectedDogRecords as $key => $dogRecord) {
            foreach($possibleClasses as $classKey => $class) {
                if($dogRecord->dog_class_id === $class->id){
                    unset($possibleClasses[$classKey]);
                }
            }
        }
        return $possibleClasses;
    }
}
