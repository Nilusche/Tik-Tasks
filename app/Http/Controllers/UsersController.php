<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Users\UpdateProfileRequest;
use RealRashid\SweetAlert\Facades\Alert;
class UsersController extends Controller
{
    public function index(){
        return view('Users.profile');
    }

    public function edit(){
        return view('Users.edit')->with('user', auth()->user());

    }

    public function update(UpdateProfileRequest $request){

        $user = auth()->user();
        if(empty($request->email)){
            $user->update([
                'name' => $request->name,
                'about'=> $request->about
            ]);
        }else{
            $user->update([
                'name' => $request->name,
                'about'=> $request->about,
                'email'=>$request->email
            ]);
        }
        
        Alert::info('Erfolg','Änderungen erfolgreich übernommen');
        return redirect()->back();

    }
}
