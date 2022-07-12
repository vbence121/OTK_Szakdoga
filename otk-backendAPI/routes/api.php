<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\JudgeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::put('/user/modify/{id}', [UserController::class, 'update']);
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout']);
});

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




/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
