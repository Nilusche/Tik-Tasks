<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use DB;
class TaskController extends Controller
{
    public function startseite(){
        return view('Main.index')->with('tasks', Task::all());
    }

    public function create(){
        return view('Main.createTask');
    }
    public function update(Task $task){
        $data = request()->all();
        if(empty($data['deadline'])){
            $task->deadline=DB::raw('CURRENT_TIMESTAMP');
            $this->validate(request(), [
                'title'=>'required',
                'estimatedEffort' =>'numeric',
                'visibility'=> 'required'
            ]);
        }else{
            $task->deadline=$data['deadline'];
            $this->validate(request(), [
                'title'=>'required',
                'estimatedEffort' =>'numeric',
                'deadline' => 'date_format:Y-m-d|after_or_equal:today',
                'visibility'=> 'required'
            ]);
        }

        
        $task->title =$data['title'];
        $task->description =$data['description'];
        $task->comment =$data['comment'];
        $task->priority=$data['priority'];
        $task->estimatedEffort=$data['effort'];
        $task->totalEffort=$data['effort2'];
        $task->visibility=$data['visibility'];
        $task->completed =false;
        $task->save();

        session()->flash('success', 'Änderungen erfolgreich übernommen');
        return redirect('/Startseite');

    }

    public function save(){
        $data = request()->all();
        $task = new Task();
        if(empty($data['deadline'])){
            $task->deadline=DB::raw('CURRENT_TIMESTAMP');
            $this->validate(request(), [
                'title'=>'required',
                'estimatedEffort' =>'numeric',
                'visibility'=> 'required'
            ]);
        }else{
            $task->deadline=$data['deadline'];
            $this->validate(request(), [
                'title'=>'required',
                'estimatedEffort' =>'numeric',
                'deadline' => 'date_format:Y-m-d|after_or_equal:today',
                'visibility'=> 'required'
            ]);
        }

        $task->title =$data['title'];
        $task->description =$data['description'];
        $task->comment =$data['comment'];
        $task->priority=$data['priority'];
        $task->estimatedEffort=$data['effort'];
        $task->totalEffort=$data['effort'];
        $task->visibility=$data['visibility'];
        $task->completed =false;
        $task->users_id = auth()->user()->id;
        $task->save();
        
        session()->flash('success', 'Aufgabe erfolgreich erstellt');
        return redirect('/Startseite');
    }

    public function destroy(Task $task){
        $task->delete();
        session()->flash('success', 'Aufgabe erfolgreich gelöscht');
        return redirect('/Startseite');
    }

    public function edit(Task $task){
        
        return view('Main.edit')->with('task', $task);
    }

    public function complete(Task $task){
        $task->completed=true;

        $task->save();
        session()->flash('success', 'Aufgabe abgeschlossen');
        return redirect('/Startseite');
    }
}
