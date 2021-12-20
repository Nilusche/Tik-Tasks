<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Users\UpdateProfileRequest;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
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

    public function showNotifications(){
        $notfications = DB::table('notifications')->orderBy('read_at','desc')->get();
        $authNotis=[];
       foreach($notfications as $notfication){
            $data = json_decode($notfication->data);
            $readat=array('read_at'=>$notfication->read_at);
            $id=array('id'=>$notfication->id);
            $data = array_merge((array)$data, $readat,$id );
            if($data['userid'] ===auth()->user()->id){
                array_push($authNotis,$data);
            }
       }
       
        return view('Main.notification')->with('notifications', $authNotis);
    }

    public function readNotifications(){
        auth()->user()->unreadNotifications->markAsRead();
        $notfications = DB::table('notifications')->orderBy('read_at','desc')->get();
        $authNotis=[];
        foreach($notfications as $notfication){
            $data = json_decode($notfication->data);
            $readat=array('read_at'=>$notfication->read_at);
            $id=array('id'=>$notfication->id);
            $data = array_merge((array)$data, $readat,$id );
            if($data['userid'] ===auth()->user()->id){
                array_push($authNotis,$data);
            }  
        }
        return view('Main.notification')->with('notifications', $authNotis);
    }

    public function deleteNotifications(){
        $notfications = DB::table('notifications')->orderBy('read_at','desc')->get();
        $authNotis=[];
        foreach($notfications as $notfication){
            $data = json_decode($notfication->data);
            $readat=array('read_at'=>$notfication->read_at);
            $id=array('id'=>$notfication->id);
            $data = array_merge((array)$data, $readat,$id );
            if($data['userid'] ===auth()->user()->id){
                array_push($authNotis,$data);
            }  
        }

        foreach($authNotis as $notis){
            DB::table('notifications')->where('id',$notis['id'])->delete();
        }
        return redirect('/UserNotifications');
    }

    public function deleteSingleNotification($id){
     DB::table('notifications')->where('id',$id)->delete();

       return redirect('/UserNotifications');
    }
}
