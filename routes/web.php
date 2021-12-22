<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\CSVController;
use App\Http\Controllers\viewGroupController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserChangePasswordController;
use App\Http\Controllers\SortController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilesController;
use App\Models\Task;
use App\Models\User;
use App\Events\MessageNotification;
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

Route::get('Startseite',[HomeController::class, 'startseite'])->middleware('auth');

Route::get('Startseite/{tag}/view',[viewGroupController::class, 'viewGroup'])->middleware('auth');


Route::get('Startseite/{tag}/view/SortbyNameAscGroup',[viewGroupController::class, 'viewGroupSortbyNameAscGroup'])->middleware('auth');
Route::get('Startseite/{tag}/view/SortbyNameDescGroup',[viewGroupController::class, 'viewGroupSortbyNameDescGroup'])->middleware('auth');
Route::get('Startseite/{tag}/view/SortbyDeadlineAscGroup',[viewGroupController::class, 'viewGroupSortbyDeadlineAscGroup'])->middleware('auth');
Route::get('Startseite/{tag}/view/SortbyDeadlineDescGroup',[viewGroupController::class, 'viewGroupSortbyDeadlineDescGroup'])->middleware('auth');
Route::get('Startseite/{tag}/view/SortbyDateOfCreationAscGroup',[viewGroupController::class, 'viewGroupSortbyDateOfCreationAscGroup'])->middleware('auth');
Route::get('Startseite/{tag}/view/SortbyDateOfCreationDescGroup',[viewGroupController::class, 'viewGroupSortbyDateOfCreationDescGroup'])->middleware('auth');
Route::get('Startseite/{tag}/view/SortbyPriorityAscGroup',[viewGroupController::class, 'viewGroupSortbyPriorityAscGroup'])->middleware('auth');
Route::get('Startseite/{tag}/view/SortbyPriorityDescGroup',[viewGroupController::class, 'viewGroupSortbyPriorityDescGroup'])->middleware('auth');

Route::get('Startseite/PublicTasks',[HomeController::class, 'startseite_publictask'])->middleware('auth');

Route::get('Create-task', [TaskController::class,'create'])->middleware('auth');

Route::post('Save-tasks',[TaskController::class,'save'])->middleware('auth');

Route::get('Startseite/{task}/delete',[TaskController::class, 'destroy'])->middleware('auth');

Route::post('Startseite/{task}/Update-tasks',[TaskController::class, 'update'])->middleware('auth');
Route::post('Startseite/{task}/Update-tasks-limited',[TaskController::class, 'updateLimited'])->middleware('auth');/// middleware noch hinzufügens
Route::get('Startseite/{task}/edit',[TaskController::class, 'edit'])->middleware('auth');;

Route::get('Startseite/{task}/complete',[TaskController::class, 'complete'])->middleware('auth');

//Tags
Route::get('Archive',[TaskController::class, 'showarchive'])->middleware('auth');
Route::get('deleteArchive', [TaskController::class, 'delArchive'])->middleware('auth');
Route::get('Group', [TaskController::class,'showtasks'])->middleware('auth');
Route::get('storeTags', [TagsController::class,'store'])->middleware('auth');
Route::post('assignTags', [TaskController::class,'assignTag'])->middleware('auth');
Route::get('Startseite/{tagid}/deleteGroup',[TagsController::class, 'deleteGroup'])->middleware('auth');

//Tasks
Route::get('Assign',[TaskController::class,'showtasksAssign'])->middleware('auth');
Route::POST('assignTasks',[TaskController::class,'assignTasks'])->middleware('auth');



//Sortierung Aufgaben
Route::get('SortbyNameAsc',[SortController::class, 'SortbyNameAsc'])->middleware('auth');
Route::get('SortbyNameDesc', [SortController::class, 'SortbyNameDesc'])->middleware('auth');
Route::get('SortbyDeadlineAsc', [SortController::class, 'SortbyDeadlineAsc'])->middleware('auth');
Route::get('SortbyDeadlineDesc', [SortController::class, 'SortbyDeadlineDesc'])->middleware('auth');
Route::get('SortbyDateAsc',[SortController::class, 'SortbyDateAsc'] )->middleware('auth');
Route::get('SortbyDateDesc',[SortController::class, 'SortbyDateDesc'] )->middleware('auth');
Route::get('SortbyPriorityAsc',[SortController::class, 'SortbyPriorityAsc'] )->middleware('auth');
Route::get('SortbyPriorityDesc',[SortController::class, 'SortbyPriorityDesc'])->middleware('auth');

//Filter Aufgaben
Route::get("search", [TaskController::class, 'searchfilter'])->middleware('auth');
Route::get("Startseite/{tag}/view/searchGroup", [TagsController::class, 'searchfilter'])->middleware('auth');

Auth::routes();
Route::get('logout', [LoginController::class, 'logout']);
Route::get('/home', [HomeController::class, 'startseite']);

//Import Export Routen
Route::post('CSVAdminImport',[CSVController::class,'import'] )->middleware('auth');
Route::get('CSVAdminExport',[CSVController::class, 'export'])->middleware('auth');
Route::post('CSVNonAdminImport',[CSVController::class,'NonAdminimport'] )->middleware('auth');
Route::get('CSVNonAdminExport',[CSVController::class, 'NonAdminexport'])->middleware('auth');
Route::get('NonAdminExportImport', [App\Http\Controllers\HomeController::class, 'NonAdminExportImport'])->middleware('auth');

//Settings Route
Route::get('Settings', [App\Http\Controllers\HomeController::class, 'settings'])->middleware('auth');

//User Routes
//Profile Routes
Route::get('Profile', [UsersController::class, 'index'])->middleware('auth');
Route::get('Profile/edit', [UsersController::class, 'edit'])->middleware('auth');
Route::put('Profile/update', [UsersController::class, 'update'])->name('users.update-profile')->middleware('auth');
Route::get('Profile/change-password', [UserChangePasswordController::class, 'index'])->middleware('auth');
Route::post('Profile/update-password', [UserChangePasswordController::class, 'store'])->middleware('auth');

//Admin Routes
Route::get('Systempanel', function(){return view('Admins.AdminSystempanel');})->middleware('auth');
Route::get('AdminExportImport', function(){return view('Admins.AdminExportImport');})->middleware('auth');

Route::get('DeleteUser', [AdminController::class, 'deleteUser'])->middleware('auth');
Route::post('DeleteUser/action',[AdminController::class, 'deleteForm'])->middleware('auth');
Route::get('EditUser',function(){return view('Admins.AdminEditUser')->with('users',User::all());})->middleware('auth');
Route::post('FindUser', [AdminController::class, 'findUser'])->middleware('auth');
Route::get('User/{user}/edit',[AdminController::class, 'edit'])->middleware('auth');
Route::post('User/{user}/update',[AdminController::class, 'updateUser'])->middleware('auth');

//Notification

Route::get('UserNotifications',[UsersController::class, 'showNotifications'])->middleware('auth');
Route::get('readNotifications',[UsersController::class, 'readNotifications'])->middleware('auth');
Route::get('/notification/{id}/read', [UsersController::class, 'readSingleNotification'])->middleware('auth');
Route::get('deleteNotifications', [UsersController::class, 'deleteNotifications'])->middleware('auth');
Route::get('/notification/{id}/delete', [UsersController::class, 'deleteSingleNotification'])->middleware('auth');
Route::get('/notification/delete', [UsersController::class, 'deleteNotifications'])->middleware('auth');

Route::get('event',function(){
    event(new MessageNotification('Neue Benachrichtigung erhalten',auth()->user()->id));
    redirect()->back();
});


//File Upload Routes
Route::post('files/add/{taskid}', [FilesController::class, 'store'])->name('files.store')->middleware('auth');
Route::get('files/{filename}', [FilesController::class, 'open'])->middleware('auth');
Route::get('files/delete/{file}', [FilesController::class, 'destroy'])->middleware('auth');

