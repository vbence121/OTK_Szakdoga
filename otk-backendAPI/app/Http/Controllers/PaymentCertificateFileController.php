<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Event;
use App\Models\PaymentCertificateFile;
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
use DateTime;

class PaymentCertificateFileController extends Controller
{
    public function uploadPaymentCertificateFile(Request $request, $dog_id, $event_id)
    {
        // ha nem a saját kutyájához akar feltölteni
        $isUserHasTheDog = DB::table('dogs')->where('user_id', '=', Auth::user()->id)->where('id', $dog_id)->get();
        if (count($isUserHasTheDog) === 0) {
            return Response("Unauthorized acces.", 403);
        }
        $this->validate(
            $request,
            [
                'file' => 'required|mimes:jpg,png,jpeg,svg,pdf,doc,csv,xlsx,xls,docx,ppt,odt,ods,odp|max:20000',
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

        PaymentCertificateFile::create([
            'generated_name' => $unique_name,
            'name' => $request->file->getClientOriginalName(),
            'dog_id' => $dog_id,
            'event_id' => $event_id,
        ]);

        return "success";
    }

    public function getUploadedFiles($dog_id, $event_id) 
    {
        // ha nem a saját kutyájához akar hozzáférni más user
        if (Auth::user()->user_type === 1) {
            $isUserHasTheDog = DB::table('dogs')->where('user_id', '=', Auth::user()->id)->where('id', $dog_id)->get();
            if (count($isUserHasTheDog) === 0) {
                return Response("Unauthorized acces.", 403);
            }
            return DB::table('payment_certificate_files')
            ->where('dog_id', '=', $dog_id)
            ->where('event_id', '=', $event_id)
            ->get();
        }
    }

    public function deleteFile($dog_id, $file_id)
    {
        // ha nem a saját kutyájához akar hozzáférni más user
        if (Auth::user()->user_type === 1) {
            $isUserHasTheDog = DB::table('dogs')->where('user_id', '=', Auth::user()->id)->where('id', $dog_id)->get();
            if (count($isUserHasTheDog) === 0) {
                return Response("Unauthorized acces.", 403);
            }
            PaymentCertificateFile::where('id', $file_id)->firstorfail()->delete();
            return "success";
        }
    }
}
