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
use App\Models\File;

class TaskController extends Controller
{
    public function create(){
        return view('Main.createTask');
    }
    
    public function update(Task $task){
        $data = request()->all();
        if(empty($data['deadline'])){
            $this->validate(request(), [
                'title'=>'required|max:50',
                'effort' =>'numeric|nullable',
                'effort2' =>'numeric|nullable',
                'visibility'=> 'required',
                'description'=>'max:500',
            ]);
        }else{
            if(!empty($data['deadline'])){
                $task->deadline=$data['deadline'];
            }
            
            $this->validate(request(), [
                'title'=>'required|max:50',
                'effort' =>'numeric|nullable',
                'effort2' =>'numeric|nullable',
                'deadline' => 'after_or_equal:today',
                'visibility'=> 'required',
                'description'=>'max:500',
            ]);
        }

        if(!empty($task->deadline)){
            $task->alarmdateInteger=$data['alarm'];
            if($data['alarm']==0){
                $date = Carbon::parse($task->deadline);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==1){
                $date = Carbon::parse($task->deadline)->subHours(1);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==2){
                $date = Carbon::parse($task->deadline)->subDays(1);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==3){
                $this->validate(request(), [
                    'effort'=>'required'
                ]);
                $hours = (int) $data['effort'];
                $date = Carbon::parse($task->deadline)->subHours($hours);
                $task->alarmdate=$date;

            }else if($data['alarm']==4){
                $task->alarmdate=null;
            }

            if($data['description'])
                if(Carbon::parse($task->deadline)->gte(Carbon::parse($task->alarmdate))){
                    $link = Link::create($data['title'], Carbon::parse($task->alarmdate),Carbon::parse($task->deadline) )->description($data['description']);
                }else{
                    $link = Link::create($data['title'],Carbon::parse($task->deadline), Carbon::parse($task->alarmdate) )->description($data['description']);
                }
               
            else{
                if(Carbon::parse($task->deadline)->gte(Carbon::parse($task->alarmdate))){
                    $link = Link::create($data['title'], Carbon::parse($task->alarmdate),Carbon::parse($task->deadline) );
                }else{
                    $link = Link::create($data['title'],Carbon::parse($task->deadline), Carbon::parse($task->alarmdate) );
                }
            }
            $task->calendarICS=$link->ics();
            $task->calendarGoogle=$link->google();
            $task->calendarWebOutlook=$link->webOutlook();
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
        
        if($data['links']){
            $links = explode(",", $data['links']);
            
            foreach($links as $link){
                $Linktag = new \App\Models\Link();
                $Linktag->name = $link;
                $Linktag->save();
                $task->links()->attach($Linktag);
            }
        }

        //session()->flash('success', 'Änderungen erfolgreich übernommen');
        Alert::success('Erfolg', 'Aufgabe wurde erfolgreich bearbeitet');
        return redirect('/Startseite');

    }

    public function updateLimited(Task $task){
        $data = request()->all();

        $this->validate(request(),[
            'alarm' =>'required',
            'description'=>'max:500',
            'effort' =>'numeric|nullable',
            'effort2' =>'numeric|nullable',
        ]);
        if(!empty($data['alarm'])){
            $task->alarmdateInteger=$data['alarm'];
            if($data['alarm']==0){
                $date = Carbon::parse($task->deadline);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==1){
                $date = Carbon::parse($task->deadline)->subHours(1);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==2){
                $date = Carbon::parse($task->deadline)->subDays(1);
                $task->alarmdate=$date;
            }
            else if($data['alarm']==3){
                $this->validate(request(), [
                    'effort'=>'required'
                ]);
                $hours = (double) $data['effort'];
                $date = Carbon::parse($task->deadline)->subHours($hours);
                $task->alarmdate=$date;

            }else if($data['alarm']==4){
                $task->alarmdate=null;
            }

            if($data['description'])
                if(Carbon::parse($task->deadline)->gte(Carbon::parse($task->alarmdate))){
                    $link = Link::create($data['title'], Carbon::parse($task->alarmdate),Carbon::parse($task->deadline) )->description($data['description']);
                }else{
                    $link = Link::create($data['title'],Carbon::parse($task->deadline), Carbon::parse($task->alarmdate) )->description($data['description']);
                }
               
            else{
                if(Carbon::parse($task->deadline)->gte(Carbon::parse($task->alarmdate))){
                    $link = Link::create($data['title'], Carbon::parse($task->alarmdate),Carbon::parse($task->deadline) );
                }else{
                    $link = Link::create($data['title'],Carbon::parse($task->deadline), Carbon::parse($task->alarmdate) );
                }
            }
            $task->calendarICS=$link->ics();
            $task->calendarGoogle=$link->google();
            $task->calendarWebOutlook=$link->webOutlook();
        }

        $task->description =$data['description'];
        $task->comment =$data['comment'];
        $task->estimatedEffort=$data['effort'];
        $task->save();


        //session()->flash('success', 'Änderungen erfolgreich übernommen');
        Alert::success('Erfolg', 'Aufgabe wurde erfolgreich bearbeitet');
        return redirect('/Startseite');

    }

    public function save(Request $request){
        $data = request()->all();
        $deadlinecompare = Carbon::now();

        $task = new Task();
        if(empty($data['deadline'])){
            $task->deadline=null;
            $this->validate(request(), [
                'title'=>'required|max:50',
                'effort' =>'numeric|nullable',
                'visibility'=> 'required',
                'description'=>'max:500'
            ]);
        }else{
            $task->deadline=$data['deadline'];
            $this->validate(request(), [
                'title'=>'required|max:50',
                'effort' =>'numeric|nullable',
                'deadline' => 'after_or_equal:today',
                'visibility'=> 'required',
                'description'=>'max:500'
            ]);
        }

        if(!empty($data['deadline'])){
            $task->alarmdateInteger=$data['alarm'];
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
                if(Carbon::parse($task->deadline)->gte(Carbon::parse($task->alarmdate))){
                    $link = Link::create($data['title'], Carbon::parse($task->alarmdate),Carbon::parse($task->deadline) )->description($data['description']);
                }else{
                    $link = Link::create($data['title'],Carbon::parse($task->deadline), Carbon::parse($task->alarmdate) )->description($data['description']);
                }
               
            else{
                if(Carbon::parse($task->deadline)->gte(Carbon::parse($task->alarmdate))){
                    $link = Link::create($data['title'], Carbon::parse($task->alarmdate),Carbon::parse($task->deadline) );
                }else{
                    $link = Link::create($data['title'],Carbon::parse($task->deadline), Carbon::parse($task->alarmdate) );
                }
            }
                
            $task->calendarICS=$link->ics();
            $task->calendarGoogle=$link->google();
            $task->calendarWebOutlook=$link->webOutlook();
        }


        $task->title =$data['title'];
        $task->description =$data['description'];
        $task->comment =$data['comment'];
        $task->priority=$data['priority'];
        $task->estimatedEffort=$data['effort'];
        $task->visibility=$data['visibility'];
        $task->completed =false;
        $task->save();

        
        if($request->hasfile('files'))
         {
            foreach($request->file('files') as $file)
            {
                $fileName = $task->id. '_' .time() .$file->getClientOriginalName(). '.' . $file->extension();

                $clientname = $file->getClientOriginalName();
                $type = $file->extension();
                $size = $file->getSize();
        
                $file->move(public_path('file'), $fileName);
                File::create([
                    'task_id' => $task->id,
                    'slug' => $clientname,
                    'name' => $fileName,
                    'type' => $type,
                    'size' => $size
                ]);
            }
         }

        if($data['links']){
            $links = explode(",", $data['links']);
            
            foreach($links as $link){
                $Linktag = new \App\Models\Link();
                $Linktag->name = $link;
                $Linktag->save();
                $task->links()->attach($Linktag);
            }
        }

        
        
        

        
        

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

                $files = File::where('task_id', $task->id)->get();
                foreach($files as $file){
                    $path = 'file/'. $file->name;
                    $file->delete();
                    unlink(public_path($path));
                }
                
                $links = $task->links;
                foreach($links as $link){
                    $link->delete();
                }
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
        $files = File::where('task_id', $task->id)->get();
        return view('Main.edit')->with('task', $task)->with('files', $files);
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
                    if($task->id == $singleTask->tasks_id && auth()->user()->id==$singleTask->users_id && $singleTask->isOwner==1){
                        DB::table('tag_task')->where('task_id',$task->id)->delete();
                        DB::table('user_has_task')->delete($singleTask->id);

                        $files = File::where('task_id', $task->id)->get();
                        foreach($files as $file){
                            $path = 'file/'. $file->name;
                            $file->delete();
                            unlink(public_path($path));
                        }
                        
                        $links = $task->links;
                        foreach($links as $link){
                            $link->delete();
                        }
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

        if(!$tasks){
            //session()->flash('error','Keinen Mitarbeiter ausgewählt');
            Alert::error('Fehler', 'Keine Aufgabe ausgewählt');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get());
        }

        //Kontrolle ob $operator gültig ist
        $operatorID = User::where('email', $operator)->first();
        if(!$operatorID){
            //session()->flash('error','Ungültige Email-Adresse');
            Alert::error('Fehler', 'Es wurde kein Mitarbeiter mit passender E-Mail gefunden');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get());
        }

        if($operatorID->id == auth()->User()->id){
            //session()->flash('error','Sie können keine Aufgaben an sich selber verteilen');
            Alert::error('Fehler', 'Sie können keine Aufgaben an sich selber verteilen');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get());
        }


        foreach($tasks as $task_id){
            //Ausführung wenn noch keine identischen Einträge gefunden wurden
            if(DB::table('user_has_task')->where('users_id','=',$operatorID->id)->where('tasks_id','=',(int)$task_id)->get()->count() == 0){
                DB::table('user_has_task')->insert(
                    array(
                        'users_id'=> $operatorID->id,
                        'tasks_id'=> (int)$task_id,
                        'isOwner'=>false
                    )
                );
            }
            else{
                Alert::warning('Erfolg aber ...', '... Mindestens eine der Aufgaben wurde dem Benutzer bereits zugewiesen');
                return redirect ('/Startseite');
            }
        }
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
            return redirect('/Group');
        }
        if(!$tags){
            //session()->flash('error', 'Keine Gruppe ausgewählt');
            Alert::error('Fehler', 'Keine Gruppe ausgewählt');
            return redirect('/Group');
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

        return redirect('/Startseite');
    }

    public function searchfilter(Request $request){
        $search = $request->input('search');
        $TaskDependencyOwner = DB::table('users')
        ->select('users.id','user_has_task.tasks_id','user_has_task.isOwner')
        ->join('user_has_task','users.id','=','user_has_task.users_id')
        ->join('tasks','tasks.id','=','user_has_task.tasks_id')
        ->where('user_has_task.isOwner','=',1)
        ->where('users.id','=',auth()->user()->id)
        ->where('tasks.completed','=',0)
        ->get();

        /*
        $viewableTags = DB::table('tags')
        ->where('users_id','=',auth()->user()->id)
        ->whereNull('parent_id')
        ->get();
        */
        $viewableTags = [];


        if($search==""){
            return view('Main.index')
            ->with('tags',$viewableTags)
            ->with('tasks', Task::all())
            ->with('TaskUserPairs', DB::table('user_has_task')->get())
            ->with('allTasks',DB::table('tasks')
            ->join('tag_task','tasks.id','=','tag_task.task_id')
            ->join('tags','tags.id','=','tag_task.tag_id')
            ->groupBy('tag_task.tag_id')->get())
            ->with('taskOwner',$TaskDependencyOwner);
            exit();
        }
        $tasks = Task::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('comment', 'LIKE', "%{$search}%")
            ->get()
            ->map(function($row) use ($search){
                $row->comment=preg_replace('/('.$search.')/', "<b class=bg-warning>$1</b>",$row->comment);
                $row->description=preg_replace('/('.$search.')/', "<b class=bg-warning>$1</b>",$row->description);
                return $row;
            });


        return view('Main.index')
        ->with('tags',$viewableTags)
        ->with('tasks',$tasks)
        ->with('TaskUserPairs', DB::table('user_has_task')->get())
        ->with('allTasks',DB::table('tasks')
            ->join('tag_task','tasks.id','=','tag_task.task_id')
            ->join('tags','tags.id','=','tag_task.tag_id')
            ->groupBy('tag_task.tag_id')->get())
        ->with('taskOwner',$TaskDependencyOwner);
    }

}
