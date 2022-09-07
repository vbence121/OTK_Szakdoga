<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\File;
use App\Models\User;
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
        return Auth::user()->dogs()->get();
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
                'breed' => 'required|string',
                'hobby' => 'required|boolean',
                'birthdate' => 'required|date',
                'breederName' => 'required|string',
                'description' => 'string|nullable',
                'motherName' => 'string|nullable',
                'fatherName' => 'string|nullable',
                'category' => 'required|string',
                'registerSernum' => 'required|string|unique:dogs',
                'registerType' => 'required|string',
            ],
            [
                'registerSernum.unique' => 'Ez a törzskönyvszám már regisztálva volt!',
            ]
        );

        //$now = date('Y-m-d H:i:s');
        $dog = Dog::create([
            'name' => $fields['name'],
            'breed' => $fields['breed'],
            'hobby' => $fields['hobby'],
            'birthdate' => $fields['birthdate'],
            'user_id' => Auth::user()->id,
            'breederName' => $fields['breederName'],
            'description' => $fields['description'],
            'motherName' => $fields['motherName'],
            'fatherName' => $fields['fatherName'],
            'category' => $fields['category'],
            'registerSernum' => $fields['registerSernum'],
            'registerType' => $fields['registerType'],
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

        //return Dog::find($id)->files()->get();

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
                'breed' => 'string',
                'hobby' => 'boolean',
                'birthdate' => 'date',
                'breederName' => 'string',
                'description' => 'string|nullable',
                'motherName' => 'string|nullable',
                'fatherName' => 'string|nullable',
                'category' => 'string',
                'registerSernum' => 'string|unique:dogs',
                'registerType' => 'string',
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

    /* public function getSelectedFile(Request $request)
    {
        $this->validate(
            $request,
            [
                'file_id' => 'required|numeric',
            ],
        );
        $file = DB::table('files')->where('id', '=', $request->file_id)->get()[0];
        if (Auth::user()->user_type === 1) {
            $usersDog = Auth::user()->dogs()->where('id', '=', $file->dog_id)->get();
            if (count($usersDog) === 0) {
                return Response("Unauthorized acces.", 403);
            }
        }
        return $fileToSendBack = public_path() . "/files/" . $file->generated_name;
        //return $fileToSendBack;

        $headers = array(
            'Content-Type' => 'image/png',
        );

        return FacadeResponse::download($fileToSendBack, $file->name, $headers);
    } */
}
