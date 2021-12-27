<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithMapping;
class CSVNonAdminExport implements FromCollection, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tasks= DB::select(
            'select *
            from tasks t
            left join user_has_task uht
            on uht.tasks_id = t.id
            left join users
            on uht.users_id = users.id
            where uht.isOwner=true and uht.users_id = :id;',['id'=>auth()->User()->id]);
        
            
        return  collect($tasks);
        
    }

    public function map($object) :array
    {
            return[
                $object->id,
                $object->title,
                $object->description,
                $object->comment,
                $object->priority,
                $object->estimatedEffort,
                $object->totalEffort,
                $object->completed == 0? "false" : "true",
                $object->completed == 0? "false" : "true",
                $object->created_at,
                $object->updated_at,
                $object->deadline,
                $object->alarmdate,
                $object->alarmdateInteger,
                $object->calendarICS,
                $object->calendarGoogle,
                $object->calendarWebOutlook,
                $object->tasks_id,
                $object->users_id,
                $object->isOwner == 0? "false" : "true",
                $object->notified_manager == 0? "false" : "true",
                $object->name,
                $object->email,
                $object->email_verified_at,
                $object->role,
                $object->email,
                $object->about,
                $object->password,
                $object->remember_token,
            ];
    }
}
