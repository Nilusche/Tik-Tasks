<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use DB;
class viewGroupController extends Controller
{
    //Weiterleitung zur Gruppenseite
    public function viewGroup(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);

        return view('Main.viewGroup')->with('tasks',$results)->with('tag_id',$tag_id)->with('tag_task',DB::table('tag_task')->get());
    }
    //Sortieren nach Name aufsteigend
    public function viewGroupSortbyNameAscGroup(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid
                                order by tasks.title asc',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);
        return view('Main.viewGroup')->with('tasks',$results)->with('tag_id',$tag_id)->with('tag_task',DB::table('tag_task')->get());
    }
    //Sortieren nach Name absteigend
    public function viewGroupSortbyNameDescGroup(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid
                                order by tasks.title desc',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);
        return view('Main.viewGroup')->with('tasks',$results)->with('tag_id',$tag_id)->with('tag_task',DB::table('tag_task')->get());
    }
    //Sortieren nach Deadline aufsteigend
    public function viewGroupSortbyDeadlineAscGroup(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid
                                order by tasks.deadline asc',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);
        return view('Main.viewGroup')->with('tasks',$results)->with('tag_id',$tag_id)->with('tag_task',DB::table('tag_task')->get());
    }
    //Sortieren nach Deadline absteigend
    public function viewGroupSortbyDeadlineDescGroup(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid
                                order by tasks.deadline desc',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);
        return view('Main.viewGroup')->with('tasks',$results)->with('tag_id',$tag_id)->with('tag_task',DB::table('tag_task')->get());
    }
    //Sortieren nach DateOfCreation aufsteigend
    public function viewGroupSortbyDateOfCreationAscGroup(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid
                                order by tasks.created_at asc',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);
        return view('Main.viewGroup')->with('tasks',$results)->with('tag_id',$tag_id)->with('tag_task',DB::table('tag_task')->get());
    }
    //Sortieren nach DateOfCreation absteigend
    public function viewGroupSortbyDateOfCreationDescGroup(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid
                                order by tasks.created_at desc',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);
        return view('Main.viewGroup')->with('tasks',$results)->with('tag_id',$tag_id)->with('tag_task',DB::table('tag_task')->get());
    }
    //Sortieren nach Priorität aufsteigend
    public function viewGroupSortbyPriorityAscGroup(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid
                                order by tasks.priority asc',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);
        return view('Main.viewGroup')->with('tasks',$results)->with('tag_id',$tag_id)->with('tag_task',DB::table('tag_task')->get());
    }
    //Sortieren nach Priorität absteigend
    public function viewGroupSortbyPriorityDescGroup(Request $request){
        $tag_id = (int)$request->tag;

        $results = DB::select('SELECT *
                                from tasks tasks
                                join tag_task tag_task
                                on tasks.id = tag_task.task_id
                                join user_has_task user_has_task
                                on user_has_task.tasks_id = tasks.id
                                where tag_task.tag_id = :t_id
                                and user_has_task.users_id = :userid
                                order by tasks.priority desc',['t_id'=>$tag_id, 'userid'=>auth()->user()->id]);
        return view('Main.viewGroup')->with('tasks',$results)->with('tag_id',$tag_id)->with('tag_task',DB::table('tag_task')->get());
    }
}
