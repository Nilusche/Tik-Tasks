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
        $viewableTags = DB::select('
            SELECT *
            from tags
            where users_id = :uid',['uid' => auth()->user()->id]);

        return view('Main.index')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get())->with('tags',DB::table('tags')->get());
    }
    public function startseite(){

        $viewableTags = DB::select('
            SELECT *
            from tags
            where users_id = :uid',['uid' => auth()->user()->id]);

        return view('Main.index')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get())->with('tags',$viewableTags);
    }
    public function startseite_tag(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);

        return view('Main.viewGroup')->with('tasks',$results);
    }


    public function settings(){
        return view('Main.settings');
    }

    public function NonAdminExportImport(){
        return view('Main.NonAdminExportImport');
    }
}
