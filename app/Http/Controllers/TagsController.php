<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\User;
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
}
