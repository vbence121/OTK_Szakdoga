<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JudgeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\RegisteredDogController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//// USER/CONTESTANT ROUTES

// Public routes
Route::get('/users', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/search/{name}', [UserController::class,'search']);
Route::get('/users/searchCustom/{type}={name}', [UserController::class,'searchCustom']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::put('/user/modify/{id}', [UserController::class, 'update']);
    Route::post('/user/delete', [UserController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/changePassword', [AuthController::class, 'changePassword']);
});



//// Judge ROUTES

// Public routes
Route::get('/judges', [JudgeController::class, 'index']);
Route::post('/judges/login', [JudgeController::class, 'login']);
Route::get('/judges/{id}', [JudgeController::class, 'show']);
Route::get('/judges/search/{id}', [JudgeController::class, 'search']);
Route::get('/users/searchCustom/{type}={name}', [UserController::class,'searchCustom']);

Route::post("/judges/register", [JudgeController::class, 'store']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('judge', [JudgeController::class, 'judge']);
    //Route::post("/judges/register", [JudgeController::class, 'store']);
    Route::put('/judges/modify/{id}', [JudgeController::class, 'update']);
    Route::post("/judges/logout", [JudgeController::class, 'logout']);
    Route::delete('/judges/delete/{id}', [JudgeController::class, 'destroy']);
});


//// Admin rouutes

// Public routes
Route::get('/admins', [AdminController::class, 'index']);
Route::post('/admins/login', [AdminController::class, 'login']);
Route::get('/admins/{id}', [AdminController::class, 'show']);
Route::get('/admins/search/{id}', [AdminController::class, 'search']);
Route::get('/admins/searchCustom/{type}={name}', [AdminController::class,'searchCustom']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post("/admins/register", [AdminController::class, 'store']);
    Route::get('admin', [AdminController::class, 'admin']);
    Route::put('/admins/modify/{id}', [AdminController::class, 'update']);
    Route::delete('/admins/delete/{id}', [AdminController::class, 'destroy']);
    Route::post("/admins/logout", [AdminController::class, 'logout']);
});


//// Password verify functions

// notify user about the need to verify their email
Route::get('/users/email/verify', function(){
    return view('auth.verify-eamil');
})->middleware('auth')->name('verification.notice');
// when user clicks verification e-mail verify it
Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
// resend verification e-mail
Route::post('/email/verification-notification', function(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back()->switch('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6.1'])->name('verification.send');

//// Password reset functions/routes
Route::post('/forgot-password', function(Request $request){
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    /*
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
    */
    return Response(["status" => __($status)]);
})->middleware('guest')->name('password.email');

Route::post('/reset-password', function(Request $request){
    $request->only('email','password','password_confirmation', 'token');

    function($user, $password){
        $user->forceFill([
            'password' => Hash::make($password)
        ])->setReminderToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
    };

    /*return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withError(['email' => [__($status)]]);
            */
    return Response(["status" => [__($status)]]);
})->middleware('guest')->name('password.update');


//// DOG ROUTES

// Public routes
Route::get('/dogs', [DogController::class, 'index']);
Route::get('/dogs/search/{name}', [DogController::class,'search']);
Route::get('/dogs/searchCustom/{type}={name}', [DogController::class,'searchCustom']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/dogs/{id}', [DogController::class, 'show']);
    Route::post('/store', [DogController::class, 'store']);
    Route::get('/mydogs', [DogController::class, 'showuserdogs']);
    Route::post('/dogs/getSelectedFile', [DogController::class, 'getSelectedFile']);
    Route::get('/dogs/getFiles/{id}', [DogController::class, 'getUploadedFilesForDog']);
    Route::post('/dogs/uploadFile/{id}', [DogController::class, 'uploadFile']);
    Route::put('/dogs/modify/{id}', [DogController::class, 'update']);
    Route::delete('/dogs/delete/{id}', [DogController::class, 'destroy']);
});


//// EVENT ROUTES

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/events/store', [EventController::class, 'store']);
    Route::get('/events/getActiveEvents', [EventController::class, 'getEvents']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::put('/events/modify/{id}', [EventController::class, 'update']);
    Route::delete('/events/delete/{id}', [EventController::class, 'destroy']);
});


//// CATEGORY ROUTES

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/categories/getCategories', [CategoryController::class, 'getCategories']);
});


//// REGISTERED DOG ROUTES

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/registeredDogs/store', [RegisteredDogController::class, 'store']);
    Route::get('/registeredDogs/getRegisteredDogsForActiveEvents', [RegisteredDogController::class, 'getRegisteredDogsForActiveEvents']);
    Route::get('/registeredDogs/getRegisteredDogsForEvent/{id}', [RegisteredDogController::class, 'getRegisteredDogsForEvent']);
    Route::post('/registeredDogs/updateStatus', [RegisteredDogController::class, 'updateStatus']);
    Route::get('/registeredDogs/getRegisteredDogsForUser', [RegisteredDogController::class, 'getRegisteredDogsForUser']);
});

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
