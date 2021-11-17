<?php

namespace App\Http\Controllers;
use Spatie\CalendarLinks\Link;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\User;

class TaskController extends Controller
{
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
            
            if($data['description'])
                $link = Link::create($data['title'], Carbon::parse($task->alarmdate), Carbon::parse($task->deadline))->description($data['description']);
            else
                $link = Link::create($data['title'], Carbon::parse($task->alarmdate), Carbon::parse($task->deadline));
            $task->calendarICS=$link->ics();
            $task->calendarGoogle=$link->google();
            $task->calendarWebOutlook=$link->webOutlook();
        }else{
            $task->alarmdate=null;
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


        //session()->flash('success', 'Änderungen erfolgreich übernommen');
        Alert::success('Erfolg', 'Aufgabe wurde erfolgreich bearbeitet');
        return redirect('/Startseite');

    }

    public function updateLimited(){
        $data = request()->all();

        $task->title =$data['title'];
        $task->description =$data['description'];
        $task->comment =$data['comment'];
        $task->estimatedEffort=$data['effort'];
        $task->totalEffort=$data['effort2'];
        $task->save();


        //session()->flash('success', 'Änderungen erfolgreich übernommen');
        Alert::success('Erfolg', 'Aufgabe wurde erfolgreich bearbeitet');
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

            if($data['description'])
                $link = Link::create($data['title'], Carbon::parse($task->alarmdate), Carbon::parse($task->deadline))->description($data['description']);
            else
                $link = Link::create($data['title'], Carbon::parse($task->alarmdate), Carbon::parse($task->deadline));
            $task->calendarICS=$link->ics();
            $task->calendarGoogle=$link->google();
            $task->calendarWebOutlook=$link->webOutlook();
        }



        $task->title =$data['title'];
        $task->description =$data['description'];
        $task->comment =$data['comment'];
        $task->priority=$data['priority'];
        $task->estimatedEffort=$data['effort'];
        $task->totalEffort=$data['effort'];
        $task->visibility=$data['visibility'];
        $task->completed =false;


        $task->save();

        DB::table('user_has_task')->insert(
            array(
                'users_id'=> auth()->user()->id,
                'tasks_id'=>$task->id,
                'isOwner'=>true
            )
        );

        //session()->flash('success', 'Aufgabe erfolgreich erstellt');
        Alert::success('Fertig', 'Aufgabe wurde erfolgreich erstellt');

        return redirect('/Startseite');
    }

    public function destroy(Task $task){

        $allTasks = DB::table('user_has_task')->get();
        foreach($allTasks as $singleTask){
            if($task->id == $singleTask->tasks_id && $singleTask->isOwner==true && $singleTask->users_id == auth()->user()->id){
                
                DB::table('user_has_task')->where('tasks_id',$task->id)->delete();
                
                $task->delete();
                //session()->flash('success', 'Aufgabe erfolgreich gelöscht');
                Alert::success('Erfolg', 'Aufgabe erfolgreich gelöscht');
                return redirect('/Startseite');
                
            }
        }
        //session()->flash('error', 'Aufgabe kann nicht gelöscht werden da sie nicht selbst erstellt wurde');
        Alert::error('Fehler', 'Aufgabe kann nicht gelöscht werden da sie nicht selbst erstellt wurde');
        return redirect('/Startseite');
    }


    public function edit(Task $task){
        $allTasks = DB::table('user_has_task')->get();
        foreach($allTasks as $singleTask){
            if($singleTask->users_id==auth()->user()->id && $singleTask->tasks_id==$task->id && $singleTask->isOwner==0){
                return view('Main.editLimited')->with('task', $task);
            }
        }
        return view('Main.edit')->with('task', $task);
    }

    public function complete(Task $task){
        $task->completed=true;
        $task->save();
        //session()->flash('success', 'Aufgabe abgeschlossen');
        Alert::success('Erfolg', 'Aufgabe abgeschlossen');
        return redirect('/Startseite');
    }

    public function showarchive(){
        return view('Main.archive')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get());
    }

    public function delArchive(){
        $tasks = Task::all();
        $allTasks = DB::table('user_has_task')->get();

        foreach($tasks as $task){
            if($task->completed == 1){
                foreach($allTasks as $singleTask){
                    if($task->id == $singleTask->tasks_id && auth()->user()->id==$singleTask->users_id){
                        DB::table('tag_task')->where('tasks_id',$task->id)->delete();
                        DB::table('user_has_task')->delete($singleTask->id);
                        $task->delete();
                    }
                }
            }
        }

        return view('Main.archive')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get());
    }

    //Aufrufen der Assign Seite
    //Es werden alle Aufgaben die zugewiesen werden können angezeigt werden können
    public function showtasksAssign(){
        return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get())->with('tags',Tag::all());
    }
    //Verarbeitung der Daten
    public function assignTasks(Request $request){
        $tasks = $request->tasks;
        $operator = $request->operator;

        //Zeige Fehlermeldung, wenn kein Operator angegeben wurde
        if(!$operator){
            //session()->flash('error','Keinen Mitarbeiter ausgewählt');
            Alert::error('Fehler', 'Keinen Mitarbeiter ausgewählt');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get());
        }

        //Kontrolle ob $operator gültig ist
        $operatorID = User::where('email', $operator)->first();
        if($operatorID->id == auth()->User()->id){
            //session()->flash('error','Sie können keine Aufgaben an sich selber verteilen');
            Alert::error('Fehler', 'Sie können keine Aufgaben an sich selber verteilen');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get());
        }
            //DB::select('select id from users where email = :operator',['operator' => $operator]);
        if(!$operatorID){
            //session()->flash('error','Ungültige Email-Adresse');
            Alert::error('Fehler', 'Ungültige Email-Adresse');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get());
        }
        //Zeige Fehlermeldung wenn kein Task angegeben wurde
        if(!$tasks){
            //session()->flash('error','Keine Aufgaben ausgewählt');
            Alert::error('Fehler', 'Keine Aufgaben ausgewählt');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get());
        }
        foreach($tasks as $task_id){
            DB::table('user_has_task')->insert(
                array(
                    'users_id'=> $operatorID->id,
                    'tasks_id'=> (int)$task_id,
                    'isOwner'=>false
                )
            );
        }
        //session()->flash('success', 'Aufgaben erfolgreich zugewiesen');
        Alert::success('Erfolg', 'Aufgaben erfolgreich zugewiesen');
        return redirect ('/Startseite');
    }

    public function showtasks(){
        return view('Main.group')->with('tasks', Task::all())->with('tags', Tag::all())
        ->with('selectedtags', DB::table('tag_task')->select('task_id','tag_id')->get())
        ->with('TaskUserPairs', DB::table('user_has_task')->get());
    }

    public function assignTag(Request $request){
        $tasks = $request->tasks;
        $tags = $request->tags;
        if(!$tasks){
            //session()->flash('error', 'Zu gruppierenden Aufgaben nicht ausgewählt');
            Alert::error('Fehler', 'Zu gruppierenden Aufgaben nicht ausgewählt');
            return view('Main.group')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get());
        }
        if(!$tags){
            //session()->flash('error', 'Keine Gruppe ausgewählt');
            Alert::error('Fehler', 'Keine Gruppe ausgewählt');
            return view('Main.group')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get());
        }
        $already_grouped=false;
        foreach($tasks as $taskid){
            $task = Task::find($taskid);
            foreach($request->tags as $tag){
                if(!$task->hasTag($tag))
                    $task->tags()->attach($tag);
                else
                    $already_grouped =true;
            }
           
        }
        if($already_grouped){
            //session()->flash('success', 'Einige der bereits gruppierten Aufgaben wurden nicht erneut hinzugefügt');
            Alert::warning('Erfolg aber ...', '... Einige der bereits gruppierten Aufgaben wurden nicht erneut hinzugefügt');
        }else{
            //session()->flash('success', 'Aufgaben erfolgreich gruppiert');
            Alert::success('Erfolg', 'Aufgaben erfolgreich gruppiert');
        }
        
        return redirect('/Group');
    }

    public function searchfilter(Request $request){
        $search = $request->input('search');
        if($search==""){
            return view('Main.index')->with('tasks', Task::all())->with('TaskUserPairs', DB::table('user_has_task')->get())->with('tags',Tag::all());
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


        return view('Main.index')->with('tasks',$tasks)->with('TaskUserPairs', DB::table('user_has_task')->get())->with('tags',Tag::all());
    }

}
