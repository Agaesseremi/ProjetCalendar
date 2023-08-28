<?php

use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("users", UserController::class); // Les routes "users.*" de l'API
Route::apiResource("tasks", TaskController::class);
Route::apiResource("members", MemberController::class);
Route::post('/auth/login', [UserController::class, 'loginUser']);
