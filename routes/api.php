<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::middleware('api')->group(function () {

Route::get('/datos', [Controller::class,'index'])->name('datos');
Route::post('/delete', [Controller::class,'delete'])->name('delete');
Route::post('/update', [Controller::class,'create_u'])->name('update');

Route::post('/deleteU', [Controller::class,'delete_u'])->name('delete');
});


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthController::class, 'getUser']);
});
