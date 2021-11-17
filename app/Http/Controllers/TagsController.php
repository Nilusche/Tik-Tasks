<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\User;
use App\Models\Task;
use DB;
class TagsController extends Controller
{
    public function store(Request $request){

        $this->validate(request(),[
            'tag' =>'required'
        ]);
        $tag = new Tag();
        $tag->name = $request->tag;
        $tag->users_id =$request->userid;
        $tag->save();

        session()->flash('success', 'Neue Gruppe erfolgreich erstellt');
        return redirect('/Group');
    }

    public function searchfilter(Request $request, Tag $tag_id){

        $search = $request->input('search');
        if($search==""){
            return view('Main.viewGroup')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get())->with('tags',Tag::all());
            exit();
        }
        $tasks = Task::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('comment', 'LIKE', "%{$search}%")
            ->get()
            ->map(function($row) use ($search){
                $row->description=preg_replace('/('.$search.')/', "<b class=bg-warning>$1</b>",$row->description);
                return $row;
            });


        return view('Main.viewGroup')->with('tasks',$tasks)->with('TaskUserPairs', DB::table('user_has_task')->get())->with('tags',Tag::all())->with('tag_id',$tag_id);
    }
}
