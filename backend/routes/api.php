<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/todolist', [TaskController::class, 'index']);
Route::post('/todolist', [TaskController::class, 'create']);
Route::patch('/todolist/{id}', [TaskController::class, 'update']);
Route::delete('/todolist/{id}', [TaskController::class, 'delete']);
