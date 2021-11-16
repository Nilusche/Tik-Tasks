<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\CSVController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Task;
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
Route::post('Startseite/{task}/Update-tasks-limited',[TaskController::class, 'updateLimited']);/// middleware noch hinzufügens
Route::get('Startseite/{task}/edit',[TaskController::class, 'edit'])->middleware('auth');;

Route::get('Startseite/{task}/complete',[TaskController::class, 'complete'])->middleware('auth');

Route::get('Archive',[TaskController::class, 'showarchive'])->middleware('auth');
Route::get('deleteArchive', [TaskController::class, 'delArchive'])->middleware('auth');
Route::get('Group', [TaskController::class,'showtasks'])->middleware('auth');
Route::get('storeTags', [TagsController::class,'store'])->middleware('auth');
Route::post('assignTags', [TaskController::class,'assignTag'])->middleware('auth');

Route::get('SortbyNameAsc', function(){return view('Main.index')->with('tasks', Task::orderBy('title')->get());})->middleware('auth');
Route::get('SortbyNameDesc', function(){return view('Main.index')->with('tasks', Task::orderBy('title', 'DESC')->get());})->middleware('auth');
Route::get('SortbyDeadlineAsc', function(){return view('Main.index')->with('tasks', Task::orderBy('deadline')->get());})->middleware('auth');
Route::get('SortbyDeadlineDesc', function(){return view('Main.index')->with('tasks', Task::orderBy('deadline', 'DESC')->get());})->middleware('auth');
Route::get('SortbyDateAsc', function(){return view('Main.index')->with('tasks', Task::orderBy('created_at')->get());})->middleware('auth');
Route::get('SortbyDateDesc', function(){return view('Main.index')->with('tasks', Task::orderBy('created_at', 'DESC')->get());})->middleware('auth');
Route::get('SortbyPriorityAsc', function(){return view('Main.index')->with('tasks', Task::orderBy('priority')->get());})->middleware('auth');
Route::get('SortbyPriorityDesc', function(){return view('Main.index')->with('tasks', Task::orderBy('priority', 'DESC')->get());})->middleware('auth');

Route::get("search", [TaskController::class, 'searchfilter'])->middleware('auth');
Auth::routes();
Route::get('logout', [LoginController::class, 'logout']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('Startseite');

Route::post('CSVAdminImport',[CSVController::class,'import'] )->middleware('auth');
Route::get('CSVAdminExport',[CSVController::class, 'export'])->middleware('auth');
Route::get('AdminExportImport', function(){return view('Main.AdminExportImport');});