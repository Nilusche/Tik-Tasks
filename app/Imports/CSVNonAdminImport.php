<?php

namespace App\Imports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\ToModel;

class CSVNonAdminImport implements ToModel
{
    
    public function model(array $row)
    {   
        
        if($row[0]==null){
            session()->flash('error', 'Datei leer oder invalide (z.B. Titel nicht gesetzt)');
        }
            
        return new Task([
            
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
    }
}
