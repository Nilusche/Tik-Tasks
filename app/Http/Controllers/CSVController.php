<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CSVAdminExportTasks;
use App\Imports\CSVAdminImportTasks;
use App\Exports\CSVNonAdminExport;
use App\Imports\CSVNonAdminImport;
use DB;
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
        return Excel::download(new CSVAdminExportTasks, 'AllTasks.csv');
    }

    public function NonAdminimport(){
        $this->validate(request(),[
            'file' => 'required'
        ]);
        try{
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
        return Excel::download(new CSVNonAdminExport, 'MyTasks.csv');
    }
}
