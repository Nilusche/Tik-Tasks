<?php

namespace App\Imports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
class CSVAdminImportTasks implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        
        if($row[0]==null){
            session()->flash('error', 'Datei leer oder invalide (z.B. Titel nicht gesetzt)');
        }
    
        $statement = DB::select("SHOW TABLE STATUS LIKE 'tasks'");
        $nextId = $statement[0]->Auto_increment;
        $task= new Task([
            'id' =>$nextId,
            'title' => $row[1] ?? null,
            'description' => $row[2] ?? null,
            'comment'=>$row[3]?? null,
            'priority' =>$row[4] ??null,
            'estimatedEffort'=>$row[5] ??null,
            'totalEffort' =>$row[6] ??null,
            'completed' =>$row[7]=="false"? false:true,
            'visibility' => $row[8]=="false"? false:true,
            'deadline' =>$row[11] ??null,
            'alarmdate' =>$row[12] ??null,
            'alarmdateInteger' =>$row[13] ??null,
            'calendarICS'=>$row[14] ??null,
            'calendarGoogle' =>$row[15] ??null, 
            'calendarWebOutlook' =>$row[16] ??null
        ]);
        
        DB::table('user_has_task')->insert(
            array(
                'users_id'=> $row[18],
                'tasks_id'=>$nextId,
                'isOwner'=>$row[19]=="false"? false:true,
                'notified_manager'=>$row[20]=="false"? false:true,
            )
        );  

        return $task;
    }
}
