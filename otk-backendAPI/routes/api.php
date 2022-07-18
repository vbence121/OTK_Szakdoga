<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\JudgeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
Route::post('/login', [UserController::class, 'login']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/search/{name}', [UserController::class,'search']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', [UserController::class, 'user']);
    Route::put('/user/modify/{id}', [UserController::class, 'update']);
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout']);
});
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



//// Judge ROUTES

// Public routes
Route::get('/judges', [JudgeController::class, 'index']);
Route::post('/judges/login', [JudgeController::class, 'login']);
Route::get('/judges/{id}', [JudgeController::class, 'show']);
Route::get('/judges/search/{id}', [JudgeController::class, 'search']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post("/judges/register", [JudgeController::class, 'store']);
    Route::post("/judges/logout", [JudgeController::class, 'logout']);
});


//// Admin rouutes
// Public routes
Route::get('/admins', [JudgeController::class, 'index']);
Route::post('/admins/login', [JudgeController::class, 'login']);
Route::get('/admins/{id}', [JudgeController::class, 'show']);
Route::get('/admins/search/{id}', [JudgeController::class, 'search']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post("/admins/register", [JudgeController::class, 'store']);
    Route::post("/admins/logout", [JudgeController::class, 'logout']);
});


//// Password reset functions/routes
Route::post('/forgot-password', function(Request $request){
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
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

    return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withError(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');


/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
