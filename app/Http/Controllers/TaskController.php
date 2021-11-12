<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;
use DB;
use Carbon\Carbon;
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

        if(!empty($data['deadline'])){
            if($data['alarm']==0){
                $date = Carbon::parse($data['deadline']);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==1){
                $date = Carbon::parse($data['deadline'])->subHours(1);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==2){
                $date = Carbon::parse($data['deadline'])->subDays(1);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==3){
                $this->validate(request(), [
                    'effort'=>'required'
                ]);
                $hours = (int) $data['effort'];
                $date = Carbon::parse($data['deadline'])->subHours($hours);
                $task->alarmdate=$date;

            }else if($data['alarm']==4){
                $task->alarmdate=null;
            }
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
            $task->deadline=null;
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
                'deadline' => '|after_or_equal:today',
                'visibility'=> 'required'
            ]);
        }

        if(!empty($data['deadline'])){
            if($data['alarm']==0){
                $date = Carbon::parse($data['deadline']);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==1){
                $date = Carbon::parse($data['deadline'])->subHours(1);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==2){
                $date = Carbon::parse($data['deadline'])->subDays(1);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==3){
                $this->validate(request(), [
                    'effort'=>'required'
                ]);
                $hours = (int) $data['effort'];
                $date = Carbon::parse($data['deadline'])->subHours($hours);
                $task->alarmdate=$date;
            }else if($data['alarm']==4){
                $task->alarmdate=null;
            }
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

    public function showarchive(){
        return view('Main.archive')->with('tasks', Task::all());
    }
    
    public function delArchive(){
        Task::where('completed',true)->delete();
        return view('Main.archive')->with('tasks', Task::all());
    }

    public function showtasks(){
        return view('Main.group')->with('tasks', Task::all())->with('tags', Tag::all())->with('selectedtags', DB::table('tag_task')->select('task_id','tag_id')->get());
    }

    public function assignTag(Request $request){
        $tasks = $request->tasks;
        $tags = $request->tags;
        if(!$tasks){
            session()->flash('error', 'Zu gruppierenden Aufgaben nicht ausgewählt');
            return view('Main.group')->with('tasks', Task::all())->with('tags', Tag::all());
        }
        if(!$tags){
            session()->flash('error', 'Keine Gruppe ausgewählt');
            return view('Main.group')->with('tasks', Task::all())->with('tags', Tag::all());
        }

        foreach($tasks as $taskid){
            $task = Task::find($taskid);
            $task->tags()->sync($request->tags);
        }

        session()->flash('success', 'Aufgaben erfolgreich gruppiert');
        return redirect('/Group');
    }
    
}
