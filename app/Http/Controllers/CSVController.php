<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CSVAdminExportTasks;
use App\Imports\CSVAdminImportTasks;
use App\Exports\CSVNonAdminExport;
use App\Imports\CSVNonAdminImport;
use DB;
use App\Models\Task;
class CSVController extends Controller
{
    public function import(Request $request){
        $this->validate(request(),[
            'file' => 'required'
        ]);
        try{
            DB::table('tasks')->delete();
            DB::table('user_has_task')->delete();
            Excel::import(new CSVAdminImportTasks, request()->file('file'));
            session()->flash('success', 'Aufgaben erfolgreich importiert');
            return back();
        }
        catch (\Exception $e){
            session()->flash('error', 'Invalide Datei ausgewählt');
            return back();
        }
        
    }

    public function export(){
        return Excel::download(new CSVAdminExportTasks, 'AllTasks.xlsx');
    }

    public function NonAdminimport(){
        $this->validate(request(),[
            'file' => 'required'
        ]);
        try{
            /*
            $tasks = Task::all();
            $allTasks = DB::table('user_has_task')->get();
            foreach($tasks as $task){
                foreach($allTasks as $singleTask){
                    if($task->id == $singleTask->tasks_id && auth()->user()->id==$singleTask->users_id){
                        DB::table('tag_task')->where('task_id',$task->id)->delete();
                        DB::table('user_has_task')->delete($singleTask->id);
                        $task->delete();
                    }
                }
            }*/

            Excel::import(new CSVNonAdminImport, request()->file('file'));
            session()->flash('success', 'Aufgaben erfolgreich importiert');
            return back();
        }
        catch (\Exception $e){
            session()->flash('error', 'Invalide Datei ausgewählt');
            return back();
        }
    }

    public function NonAdminexport(){
        return Excel::download(new CSVNonAdminExport, 'MyTasks.xlsx');
    }
}
