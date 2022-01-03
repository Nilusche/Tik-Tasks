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
use Illuminate\Support\Facades\App;
class TaskController extends Controller
{
    public function create(){
        return view('Main.createTask');
    }
    
    public function urlexists($string){
        $url = 'https://'. $string;
          
        // Use curl_init() function to initialize a cURL session
        $curl = curl_init($url);
        
        // Use curl_setopt() to set an option for cURL transfer
        curl_setopt($curl, CURLOPT_NOBODY, true);
        
        // Use curl_exec() to perform cURL session
        $result = curl_exec($curl);
        $ret = false;
        if ($result !== false) {
            
            // Use curl_getinfo() to get information
            // regarding a specific transfer
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
            
            if ($statusCode == 404) {
                $ret = false;
            }
            else {
                $ret = true;
            }
        }
        else {
            $ret = false;
        }
        return $ret;
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
        
        if(!$data['overridelinks']){
            if($data['links']){
                $links = explode(",", $data['links']);
                
                foreach($links as $link){
                    if($this->urlexists($link)){
                        $Linktag = new \App\Models\Link();
                        $Linktag->name = $link;
                        $Linktag->save();
                        $task->links()->attach($Linktag);
                    }else{
                        if(App::currentLocale()=='de')
                            Alert::error('Error', 'Bitte geben sie domains ein');
                        else
                            Alert::error('Error', 'Pls provide valid domains');
                        return redirect()->back();
                    }
                }
            }
        }else{
                $links = explode(",", $data['overridelinks']);
                $array =[];
                foreach($links as $link){
                    if($this->urlexists($link)){
                        $Linktag = new \App\Models\Link();
                        $Linktag->name = $link;
                        $Linktag->save();
                        array_push($array, $Linktag->id);
                    }else{
                        if(App::currentLocale()=='de')
                            Alert::error('Error', 'Bitte geben sie domains ein');
                        else
                            Alert::error('Error', 'Pls provide valid domains');
                        return redirect()->back();
                    }
                }
                $task->links()->sync($array);
        }
        

        //session()->flash('success', 'Änderungen erfolgreich übernommen');
        if(App::currentLocale()=='de')
            Alert::success('Erfolg', 'Aufgabe wurde erfolgreich bearbeitet');
        else
            Alert::success('Success', 'Task edited successfully');
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
        $task->totalEffort=$data['effort2'];
        $task->save();


        if($data['links']){
            $links = explode(",", $data['links']);
            
            foreach($links as $link){
                if($this->urlexists($link)){
                    $Linktag = new \App\Models\Link();
                    $Linktag->name = $link;
                    $Linktag->save();
                    $task->links()->attach($Linktag);
                }else{
                    if(App::currentLocale()=='de')
                        Alert::error('Error', 'Bitte geben sie domains ein');
                    else
                        Alert::error('Error', 'Pls provide valid domains');
                    return redirect()->back();
                }
                
            }
        }
        


        //session()->flash('success', 'Änderungen erfolgreich übernommen');
        if(App::currentLocale()=='de')
            Alert::success('Erfolg', 'Aufgabe wurde erfolgreich bearbeitet');
        else
            Alert::success('Success', 'Task edited successfully');
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
                if($this->urlexists($link)){
                    $Linktag = new \App\Models\Link();
                    $Linktag->name = $link;
                    $Linktag->save();
                    $task->links()->attach($Linktag);
                }else{
                    if(App::currentLocale()=='de')
                        Alert::error('Error', 'Bitte geben sie domains ein');
                    else
                        Alert::error('Error', 'Pls provide valid domains');
                    return redirect()->back();
                }
                
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
        if(App::currentLocale()=='de')
            Alert::success('Fertig', 'Aufgabe wurde erfolgreich erstellt');
        else
            Alert::success('Success', 'Task has been created successfully');

        return redirect('/Startseite');
    }

    public function destroy(Task $task){

        $allTasks = DB::table('user_has_task')->get();
        foreach($allTasks as $singleTask){
            if($task->id == $singleTask->tasks_id && $singleTask->isOwner==true && $singleTask->users_id == auth()->user()->id){

                DB::table('user_has_task')->where('tasks_id',$task->id)->delete();

                //Dateien löschen
                $files = File::where('task_id', $task->id)->get();
                foreach($files as $file){
                    $path = 'file/'. $file->name;
                    $file->delete();
                    try{
                        unlink(public_path($path));
                    }catch(Exception $e){
                        
                    }
                    
                }

                //Benachrichtigungen löschen
                $notfications = DB::table('notifications')->orderBy('read_at','desc')->get();
                $authNotis=[];
                foreach($notfications as $notfication){
                    $data = json_decode($notfication->data);
                    $readat=array('read_at'=>$notfication->read_at);
                    $id=array('id'=>$notfication->id);
                    $data = array_merge((array)$data, $readat,$id );
                    if($data['userid'] ===auth()->user()->id){
                        array_push($authNotis,$data);
                    }  
                }

                foreach($authNotis as $noti){
                    if($noti['taskid']==$task->id){
                        DB::table('notifications')->where('id',$id)->delete();
                    }
                }


                //links löschen
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
        if(App::currentLocale()=='de')
            Alert::error('Fehler', 'Aufgabe kann nicht gelöscht werden da sie nicht selbst erstellt wurde');
        else
            Alert::error('Error', 'Error only the owner of the task can delete it');
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
        if(App::currentLocale()=='de')
            Alert::success('Erfolg', 'Aufgabe abgeschlossen');
        else
            Alert::success('Success', 'Task finished');
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

                        //Dateien löschen
                        $files = File::where('task_id', $task->id)->get();
                        foreach($files as $file){
                            $path = 'file/'. $file->name;
                            $file->delete();
                            unlink(public_path($path));
                        }

                        //Benachrichtigungen löschen
                        $notfications = DB::table('notifications')->orderBy('read_at','desc')->get();
                        $authNotis=[];
                        foreach($notfications as $notfication){
                            $data = json_decode($notfication->data);
                            $readat=array('read_at'=>$notfication->read_at);
                            $id=array('id'=>$notfication->id);
                            $data = array_merge((array)$data, $readat,$id );
                            if($data['userid'] ===auth()->user()->id){
                                array_push($authNotis,$data);
                            }  
                        }

                        foreach($authNotis as $noti){
                            if($noti['taskid']==$task->id){
                                DB::table('notifications')->where('id',$id)->delete();
                            }
                        }
                        
                        //links löschen
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
        return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get())->with('tags',Tag::all())->with('users', User::all());
    }
    //Verarbeitung der Daten
    public function assignTasks(Request $request){
        $tasks = $request->tasks;
        $operator = $request->operator;

        //Zeige Fehlermeldung, wenn kein Operator angegeben wurde
        if(!$operator){
            //session()->flash('error','Keinen Mitarbeiter ausgewählt');
            if(App::currentLocale()=='de')
                Alert::error('Fehler', 'Keinen Mitarbeiter ausgewählt');
            else
                Alert::error('Error', 'No user to assign tasks chosen');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get())->with('users', User::all());
        }

        if(!$tasks){
            //session()->flash('error','Keinen Mitarbeiter ausgewählt');
            if(App::currentLocale()=='de')
                Alert::error('Fehler', 'Keine Aufgabe ausgewählt');
            else
                Alert::error('Error', 'No Tasks to assign selected');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get())->with('users', User::all());
        }

        //Kontrolle ob $operator gültig ist
        $operatorID = User::where('email', $operator)->first();
        if(!$operatorID){
            //session()->flash('error','Ungültige Email-Adresse');
            if(App::currentLocale()=='de')
                Alert::error('Fehler', 'Es wurde kein Mitarbeiter mit passender E-Mail gefunden');
            else
                Alert::error('Error', 'A user with this email has not been found');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get())->with('users', User::all());
        }

        if($operatorID->id == auth()->User()->id){
            //session()->flash('error','Sie können keine Aufgaben an sich selber verteilen');
            if(App::currentLocale()=='de')
                Alert::error('Fehler', 'Sie können keine Aufgaben an sich selber verteilen');
            else
                Alert::error('Error', 'You can not assign task to yourself');
            return view('Main.assign')->with('tasks', Task::all())->with('TaskUserPairs',DB::table('user_has_task')->get())->with('users', User::all());
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
                if(App::currentLocale()=='de')
                    Alert::warning('Erfolg aber ...', '... Mindestens eine der Aufgaben wurde dem Benutzer bereits zugewiesen');
                else
                    Alert::warning('Success but ...', '... At least on of the tasks have been assigned to this user already');
                return redirect ('/Startseite');
            }
        }
        if(App::currentLocale()=='de')
            Alert::success('Erfolg', 'Aufgaben erfolgreich zugewiesen');
        else
            Alert::success('Success', 'Tasks assigned successfully');
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
            if(App::currentLocale()=='de')
                Alert::error('Fehler', 'Zu gruppierenden Aufgaben nicht ausgewählt');
            else
                Alert::error('Error', 'Tasks to group not chosen');
            return redirect('/Group');
        }
        if(!$tags){
            //session()->flash('error', 'Keine Gruppe ausgewählt');
            if(App::currentLocale()=='de')
                Alert::error('Fehler', 'Keine Gruppe ausgewählt');
            else
                Alert::error('Error', 'No groups chosen');
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
            if(App::currentLocale()=='de')
                Alert::warning('Erfolg aber ...', '... Einige der bereits gruppierten Aufgaben wurden nicht erneut hinzugefügt');
            else
                Alert::warning('Success but ...', '... Some of the already group tasks have not been added again');
        }else{
            //session()->flash('success', 'Aufgaben erfolgreich gruppiert');
            if(App::currentLocale()=='de')
                Alert::success('Erfolg', 'Aufgaben erfolgreich gruppiert');
            else
                Alert::success('Erfolg', 'Tasks grouped successfully');
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
