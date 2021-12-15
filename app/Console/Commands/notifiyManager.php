<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\NotifyUser;
use Illuminate\Support\Facades\Notification;
use App\Models\Task;
use DB;
use App\Models\User;
use Carbon\Carbon;
use App\Events\MessageNotification;
class notifiyManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:notifymanager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifys the Manager when a User finished a task';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        

        $tasks = Task::all();
        $taskAssociation = DB::table('user_has_task')->get();
        $users = User::all();
        foreach($users as $user){
            if($user->role=='manager'){
                foreach($taskAssociation as $assoc){
                    if($assoc->users_id == $user->id && $assoc->isOwner==1){
                        $id = $assoc->tasks_id;
                        foreach($taskAssociation as $assoc2){
                            if($assoc2->users_id == $user->id && $assoc2->isOwner==1 && $assoc2->tasks_id == $id && $assoc2->notified_manager==false){
                                foreach($tasks as $task){
                                    if($task->completed && $task->id == $id){
                                        $assoc2->notified_manager=true;
                                        DB::table('user_has_task')
                                        ->where('id', $assoc2->id)  
                                        ->update(array('notified_manager' =>true));  
                                        Notification::send($user,new NotifyUser($task->title, "", $task->id, $user->id)); 
                                        event(new MessageNotification('Ein Mitarbeiter hat gerade eine Aufgabe beendet', $user->id)); 
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
        }
        
    }
}
