<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Task;
class SortController extends Controller
{
    public function SortbyNameAsc(){
        $TaskDependencyOwner = DB::table('users')
        ->select('users.id','user_has_task.tasks_id','user_has_task.isOwner')
        ->join('user_has_task','users.id','=','user_has_task.users_id')
        ->join('tasks','tasks.id','=','user_has_task.tasks_id')
        ->where('user_has_task.isOwner','=',1)
        ->where('users.id','=',auth()->user()->id)
        ->where('tasks.completed','=',0)
        ->get();

        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->whereNull('parent_id')
        ->get();

        return view('Main.index')
        ->with('tags',$viewableTags)
        ->with('allTasks',DB::table('tasks')
        ->join('tag_task','tasks.id','=','tag_task.task_id')
        ->join('tags','tags.id','=','tag_task.tag_id')
        ->groupBy('tag_task.tag_id')->get())
        ->with('tasks', Task::orderBy('title','ASC')->get())
        ->with('TaskUserPairs',DB::table('user_has_task')->get())
        ->with('taskOwner',$TaskDependencyOwner);
    }

    public function SortbyNameDesc(){
        $TaskDependencyOwner = DB::table('users')
        ->select('users.id','user_has_task.tasks_id','user_has_task.isOwner')
        ->join('user_has_task','users.id','=','user_has_task.users_id')
        ->join('tasks','tasks.id','=','user_has_task.tasks_id')
        ->where('user_has_task.isOwner','=',1)
        ->where('users.id','=',auth()->user()->id)
        ->where('tasks.completed','=',0)
        ->get();
        
        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->whereNull('parent_id')
        ->get();

        return view('Main.index')
        ->with('tags',$viewableTags)
        ->with('allTasks',DB::table('tasks')
        ->join('tag_task','tasks.id','=','tag_task.task_id')
        ->join('tags','tags.id','=','tag_task.tag_id')
        ->groupBy('tag_task.tag_id')->get())
        ->with('tasks', Task::orderBy('title','DESC')->get())
        ->with('TaskUserPairs',DB::table('user_has_task')->get())
        ->with('taskOwner',$TaskDependencyOwner);
    }
    public function SortbyDeadlineAsc(){
        $TaskDependencyOwner = DB::table('users')
        ->select('users.id','user_has_task.tasks_id','user_has_task.isOwner')
        ->join('user_has_task','users.id','=','user_has_task.users_id')
        ->join('tasks','tasks.id','=','user_has_task.tasks_id')
        ->where('user_has_task.isOwner','=',1)
        ->where('users.id','=',auth()->user()->id)
        ->where('tasks.completed','=',0)
        ->get();

        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->whereNull('parent_id')
        ->get();

        return view('Main.index')->with('tags',$viewableTags)
        ->with('allTasks',DB::table('tasks')
        ->join('tag_task','tasks.id','=','tag_task.task_id')
        ->join('tags','tags.id','=','tag_task.tag_id')
        ->groupBy('tag_task.tag_id')->get())
        ->with('tasks', Task::orderBy('deadline')->get())
        ->with('TaskUserPairs',DB::table('user_has_task')->get())
        ->with('taskOwner',$TaskDependencyOwner);
    }
    public function SortbyDeadlineDesc(){
        $TaskDependencyOwner = DB::table('users')
        ->select('users.id','user_has_task.tasks_id','user_has_task.isOwner')
        ->join('user_has_task','users.id','=','user_has_task.users_id')
        ->join('tasks','tasks.id','=','user_has_task.tasks_id')
        ->where('user_has_task.isOwner','=',1)
        ->where('users.id','=',auth()->user()->id)
        ->where('tasks.completed','=',0)
        ->get();

        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->whereNull('parent_id')
        ->get();

        return view('Main.index')->with('tags',$viewableTags)
        ->with('allTasks',DB::table('tasks')
        ->join('tag_task','tasks.id','=','tag_task.task_id')
        ->join('tags','tags.id','=','tag_task.tag_id')
        ->groupBy('tag_task.tag_id')->get())
        ->with('tasks', Task::orderBy('deadline','DESC')->get())
        ->with('TaskUserPairs',DB::table('user_has_task')->get())
        ->with('taskOwner',$TaskDependencyOwner);
    }

    public function SortbyDateAsc(){
        $TaskDependencyOwner = DB::table('users')
        ->select('users.id','user_has_task.tasks_id','user_has_task.isOwner')
        ->join('user_has_task','users.id','=','user_has_task.users_id')
        ->join('tasks','tasks.id','=','user_has_task.tasks_id')
        ->where('user_has_task.isOwner','=',1)
        ->where('users.id','=',auth()->user()->id)
        ->where('tasks.completed','=',0)
        ->get();

        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->whereNull('parent_id')
        ->get();

        return view('Main.index')
        ->with('tags',$viewableTags)
        ->with('allTasks',DB::table('tasks')
        ->join('tag_task','tasks.id','=','tag_task.task_id')
        ->join('tags','tags.id','=','tag_task.tag_id')
        ->groupBy('tag_task.tag_id')->get())
        ->with('tasks', Task::orderBy('created_at')->get())
        ->with('TaskUserPairs',DB::table('user_has_task')->get())
        ->with('taskOwner',$TaskDependencyOwner);
    }

    public function SortbyDateDesc(){
        $TaskDependencyOwner = DB::table('users')
        ->select('users.id','user_has_task.tasks_id','user_has_task.isOwner')
        ->join('user_has_task','users.id','=','user_has_task.users_id')
        ->join('tasks','tasks.id','=','user_has_task.tasks_id')
        ->where('user_has_task.isOwner','=',1)
        ->where('users.id','=',auth()->user()->id)
        ->where('tasks.completed','=',0)
        ->get();

        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->whereNull('parent_id')
        ->get();

        return view('Main.index')
        ->with('tags',$viewableTags)
        ->with('allTasks',DB::table('tasks')
        ->join('tag_task','tasks.id','=','tag_task.task_id')
        ->join('tags','tags.id','=','tag_task.tag_id')
        ->groupBy('tag_task.tag_id')->get())
        ->with('tasks', Task::orderBy('created_at', 'DESC')->get())
        ->with('TaskUserPairs',DB::table('user_has_task')->get())
        ->with('taskOwner',$TaskDependencyOwner);
    }
    public function SortbyPriorityAsc(){
        $TaskDependencyOwner = DB::table('users')
        ->select('users.id','user_has_task.tasks_id','user_has_task.isOwner')
        ->join('user_has_task','users.id','=','user_has_task.users_id')
        ->join('tasks','tasks.id','=','user_has_task.tasks_id')
        ->where('user_has_task.isOwner','=',1)
        ->where('users.id','=',auth()->user()->id)
        ->where('tasks.completed','=',0)
        ->get();

        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->whereNull('parent_id')
        ->get();

        return view('Main.index')
        ->with('tags',$viewableTags)
        ->with('allTasks',DB::table('tasks')
        ->join('tag_task','tasks.id','=','tag_task.task_id')
        ->join('tags','tags.id','=','tag_task.tag_id')
        ->groupBy('tag_task.tag_id')->get())
        ->with('tasks', Task::orderBy('priority')->get())
        ->with('TaskUserPairs',DB::table('user_has_task')->get())

        ->with('taskOwner',$TaskDependencyOwner);

    }

    public function SortbyPriorityDesc(){
        $TaskDependencyOwner = DB::table('users')
        ->select('users.id','user_has_task.tasks_id','user_has_task.isOwner')
        ->join('user_has_task','users.id','=','user_has_task.users_id')
        ->join('tasks','tasks.id','=','user_has_task.tasks_id')
        ->where('user_has_task.isOwner','=',1)
        ->where('users.id','=',auth()->user()->id)
        ->where('tasks.completed','=',0)
        ->get();  
        
        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->whereNull('parent_id')
        ->get();


        return view('Main.index')
        ->with('tags',$viewableTags)
        ->with('allTasks',DB::table('tasks')
        ->join('tag_task','tasks.id','=','tag_task.task_id')
        ->join('tags','tags.id','=','tag_task.tag_id')
        ->groupBy('tag_task.tag_id')->get())
        ->with('tasks', Task::orderBy('priority','DESC')->get())
        ->with('TaskUserPairs',DB::table('user_has_task')->get())
        ->with('taskOwner',$TaskDependencyOwner);

    }
}
