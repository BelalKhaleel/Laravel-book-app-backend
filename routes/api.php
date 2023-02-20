<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Post('/author',[BookController::class,'addAuthor']);
Route::Get('/author/{id}',[BookController::class,'getAuthor']);
Route::delete('/author/{id}',[BookController::class,'deleteAuthor']);
Route::Post('/profile',[BookController::class,'addProfile']);
Route::Post('/category',[BookController::class,'addCategory']);
Route::Post('/book',[BookController::class,'addBook']);
Route::Get('/book/{id}',[BookController::class,'getBook']);
Route::Patch('/book/{id}',[BookController::class,'editBook']);