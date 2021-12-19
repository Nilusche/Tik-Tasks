<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Users\AdminUserupdateRequest;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function deleteUser(){
        return view('Admins.AdminDeleteUser')->with('users', User::all());
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

        Alert::success('Erfolg', 'Der Benutzer und seine zugehörigen Aufgaben wurden erfolgreich gelöscht');
        return redirect("/DeleteUser");
    }
  
    public function edit(User $user){
        return view('Admins.AdminUpdateUser')->with('user', $user);
    }
    //Warum zum fick UpdateUser und nicht Create User @Nilusche :(
    public function updateUser(Request $request, User $user){
        
        if(!empty($request->name)){
            $this->validate(request(),[
                'name' => 'required|max:255',
            ]);
            $user->update([
                'name' =>$request->name,
            ]);
        }
        if(!empty($request->email)){
            $this->validate(request(),[
                'email' =>'required|unique:users|email',
            ]);
            $user->update([
                'email' =>$request->email,
            ]);
        }
        if(!empty($request->password)){
            $this->validate(request(),[
                'password' =>'required|min:8',
                'confirmpassword'=>'required|same:password'
            ]);
            $user->update([
                'password' =>Hash::make($request->password),
            ]);
        }

        if(!empty($request->role)){
            $user->update([
                'role' => $request->role
            ]);
        }
        Alert::success('Erfolg','Benutzeränderungen erfolgreich übernommen');
        return redirect('/EditUser');
    }

    public function findUser(Request $request){
        $this->validate(request(),[
            'Benutzer' =>'required'
        ]);

        $user = User::find($request->Benutzer);

        if($user!=null){
            if($user->id == auth()->user()->id){
                Alert::error('Fehler','Um ihre eigenen Daten zu ändern, navigieren sie bitte zur Profilseite');
                return redirect()->back();
            }
            return redirect('/User/'.$user->id.'/edit/');
        }
        Alert::error('Fehler','Benutzer existiert nicht');
        return redirect()->back();
    }
}
