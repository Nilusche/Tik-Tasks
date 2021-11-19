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
    public function deleteForm(){
        return view('Admins.AdminDeleteUser');
    }
    public function edit(User $user){
        return view('Admins.AdminUpdateUser')->with('user', $user);
    }
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
        
        
        
        Alert::success('Erfolg','Benutzeränderungen erfolgreich übernommen');
        return redirect('/EditUser');
    }

    public function findUser(Request $request){
        $this->validate(request(),[
            'email' =>'required|email'
        ]);

        $user = User::where('email', '=', $request->email)->first();

        
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
