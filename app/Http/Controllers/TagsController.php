<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\User;
use App\Models\Task;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

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

        Alert::success('Erfolg', 'Neue Gruppe erfolgreich erstellt');
        return redirect('/Group');
    }

    public function searchfilter(Request $request){
        $tag_id = (int)$request->tag;
        $search = $request->input('search');
        if($search==""){
            return view('Main.viewGroup')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get())->with('tags',Tag::all())->with('tag_task',DB::table('tag_task')->get())->with('tag_id',$tag_id);
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


        return view('Main.viewGroup')->with('tasks',$tasks)->with('TaskUserPairs', DB::table('user_has_task')->get())->with('tags',Tag::all())->with('tag_task',DB::table('tag_task')->get())->with('tag_id',$tag_id);
    }

    public function deleteGroup(Request $request){
        $tagid = $request->tagid;
        //Löschen von tag_task

        //Delete all where tag_id = $tag_id
        DB::table('tag_task')->where('tag_id','=',$tagid)->delete();
        //Löschen von Tag eintrag
        DB::table('tags')->where('id','=',$tagid)->delete();
        
        
        
        
        Alert::success('Erfolg', 'Gruppe wurde erfolgreich gelöscht');
        return redirect('/Startseite');
    }
}
