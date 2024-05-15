<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\DocumentController;

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

//authentication routes
    Route::post('/register',[AuthController::class,'register'])->name('register');
    Route::post('/login',[AuthController::class,'login'])->name('login');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth:api'); 

//folder routes

Route::middleware('auth:api')->controller(FolderController::class)->group(function () {

    Route::get('/folders', [FolderController::class,'getAlldocs'])->name('folders');
    Route::get('/showfolders/{folder}', 'show')->name('showfolders');
    Route::post('/addfolder', 'store')->name('addfolder')->middleware('auth:sanctum');
    Route::delete('/deletefolder/{folder}', 'destroy')->name('deletefolder')->middleware('auth:sanctum');
});


Route::middleware('auth:api')->controller(DocumentController::class)->group(function () {

    Route::get('/documents', 'getAlldocs')->name('documents');
    Route::get('/retrievedocument/{document}', 'retrieve_document')->name('retrievedocument');
    Route::post('/upload', 'upload')->name('upload')->middleware('auth:sanctum');
  // Route::post('/zipfolder/{folder}', 'zipfolder')->name('zipfolder')->middleware('auth:sanctum');
   //Route::get('/downloadfolder/{folder}', 'download')->name('downloadfolder')->middleware('auth:sanctum');
    Route::delete('/deletedocument/{document}', 'destroy')->name('deletedocument')->middleware('auth:sanctum');
});

