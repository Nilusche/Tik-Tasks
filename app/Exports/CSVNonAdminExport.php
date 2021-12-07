<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
class CSVNonAdminExport implements FromCollection
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
            where uht.users_id = :id;',['id'=>auth()->User()->id]);
        
            
        return  collect($tasks);
        
    }
}
