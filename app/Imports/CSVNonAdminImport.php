<?php

namespace App\Imports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
class CSVNonAdminImport implements ToModel
{
    
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
            'completed' =>false,
            'visibility' => false,
            'deadline' =>$row[11] ??null,
            'alarmdate' =>$row[12] ??null,
            'calendarICS'=>$row[13] ??null,
            'calendarGoogle' =>$row[14] ??null, 
            'calendarWebOutlook' =>$row[15] ??null
        ]);
        
        DB::table('user_has_task')->insert(
            array(
                'users_id'=> $row[17],
                'tasks_id'=>$nextId,
                'isOwner'=>$row[18]
            )
        );  

        return $task;
    }
}
