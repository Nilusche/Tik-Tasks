<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class AdminController extends Controller
{
    public function deleteUser(){
        return view('Admins.AdminDeleteUser');
    }
    public function deleteForm(Request $request){
        $first_email = $request->femail;
        $second_email = $request->semail;

        //
        // Eingaben Validieren
        //

        //Kontrolle ob Emails identisch sind
        if($first_email != $second_email){
            Alert::error('Error', 'Die angegebenden Emails sind nicht identisch');
            return redirect("/DeleteUser");
        }

        //Kontrolle ob account existiert
        $user = DB::table('users')
            ->where('email','like',$first_email)
            ->get();

        if($user->isEmpty()){
            Alert::error('Error', 'Es wurde kein Account, zu der angegebenen Email, gefunden');
            return redirect("/DeleteUser");
        }

        //Admin darf sein eigenes Konto nicht entfernen
        if($user->first()->id == auth()->user()->id){
            Alert::error('Error', 'Der eigene Account kann nicht entfernt werden');
            return redirect("/DeleteUser");
        }

        //
        // Löschprozess
        //

        //Benötigte Werte und Values
        $userid = $user->first()->id; //Die ID des zu löschenden Accounts
        $gruppen_ids = []; //ID's der vom Nutzer erstellten Tags
        $tasks_ids = []; //ID's der vom Nutzer erstellten Aufgaben
        
       
        
        //Abfragen der Werte
        //
        // Gruppen IDS
        //
        $query = DB::table('tags')
                        ->select('id')
                        ->where('users_id','=',$userid)
                        ->get();
        
        foreach($query as $tid){
            array_push($gruppen_ids, $tid);
        }
        //
        // Tasks IDS
        //
        $query = DB::table('user_has_task')
                        ->select('id')
                        ->where('users_id','=',(int)$userid)
                        ->where('isOwner','=',1)
                        ->get();
        
        foreach($query as $tid){
            array_push($tasks_ids,$tid);
        }
        //
        // Aus Tabellen Daten löschen
        //
        //Tasks Einträge löschen
        foreach($tasks_ids as $taskid){
            //Löschen der Tasks
            DB::table('tasks')
            ->where('id','=',$taskid->id)
            ->delete();
            //Löschen der Taskzuweisung
            DB::table('user_has_task')
            ->where('tasks_id','=',$taskid->id)
            ->delete();
            //Löschen aller Tagzuweisungen
            DB::table('tag_task')
            ->where('tag_id','=',$taskid->id)
            ->delete();
        }
        //Löschen aller Gruppen 
        DB::table('tags')
        ->where('users_id','=',$userid)
        ->delete();
        //Löschen des Benutzers
        DB::table('users')
            ->where('id','=',$userid)
            ->delete();

        Alert::success('Erfolg', 'Button wird erfolgreich weitergeleitet');
        return redirect("/DeleteUser");
    }
}
