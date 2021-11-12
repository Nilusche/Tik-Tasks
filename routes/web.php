<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function(){
    return view('Main.landingpage');
});

Route::get('welcome',function(){
    return view('welcome');
});

Route::get('Startseite',[TaskController::class, 'startseite'])->middleware('auth');

Route::get('Create-task', [TaskController::class,'create'])->middleware('auth');

Route::post('Save-tasks',[TaskController::class,'save'])->middleware('auth');

Route::get('Startseite/{task}/delete',[TaskController::class, 'destroy'])->middleware('auth');

Route::post('Startseite/{task}/Update-tasks',[TaskController::class, 'update'])->middleware('auth');

Route::get('Startseite/{task}/edit',[TaskController::class, 'edit'])->middleware('auth');;

Route::get('Startseite/{task}/complete',[TaskController::class, 'complete'])->middleware('auth');

Route::get('Archive',[TaskController::class, 'showarchive'])->middleware('auth');
Route::get('deleteArchive', [TaskController::class, 'delArchive'])->middleware('auth');

Route::get('Group', [TaskController::class,'showtasks'])->middleware('auth');

Route::get('storeTags', [TagsController::class,'store'])->middleware('auth');
Route::POST('assignTags', [TaskController::class,'assignTag'])->middleware('auth');

Auth::routes();
Route::get('logout', [LoginController::class, 'logout']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('Startseite');

