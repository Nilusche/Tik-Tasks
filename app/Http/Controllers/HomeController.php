<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->get();

        return view('Main.index')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get())->with('tags',DB::table('tags')->get());
    }
    public function startseite(){

        $allTasks = DB::table('tasks')
        ->join('tag_task','tasks.id','=','tag_task.task_id')
        ->join('tags','tags.id','=','tag_task.tag_id')
        ->groupBy('tag_task.tag_id')
        ->get();

        $tasksWithTags = DB::table('tasks')
        ->leftjoin('tag_task','tasks.id','=','tag_task.task_id')
        ->leftjoin('tags','tags.id','=','tag_task.tag_id')
        ->where('tag_task.tag_id','is not','null')
        ->get();

        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->get();

        return view('Main.index')->with('tasks', Task::all())
        ->with('TaskUserPairs', DB::table('user_has_task')->get())
        ->with('tags',$viewableTags)
        ->with('allTasks',$allTasks)
        ->with('tasksWithTags',$tasksWithTags);
    }

    public function startseite_publictask(){
        //Alle Aufgaben, die nicht vom Manager erstellt wurden und öffentlich sind, werden hier abgefragt
        $publicTasks = DB::table('tasks')
        ->leftjoin('user_has_task','user_has_task.tasks_id','=','tasks.id')
        ->leftjoin('users','user_has_task.users_id','=','users.id')
        ->where('user_has_task.users_id','<>',auth()->user()->id)
        ->where('user_has_task.isOwner','<>',0)
        ->where('tasks.visibility','=',1)
        ->get();

        return view('Main.viewPublicTasks')->with('publicTasks',$publicTasks);
    }


    public function settings(){
        return view('Main.settings');
    }

    public function NonAdminExportImport(){
        return view('Main.NonAdminExportImport');
    }
}
