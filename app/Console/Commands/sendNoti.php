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
class sendNoti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifys the User when a task is due';

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
        
        $tasks = Task::whereNotNull('alarmdate')->get();
        $taskAssociation = DB::table('user_has_task')->get();
        $users = User::all();
        foreach($users as $user){
            foreach($taskAssociation as $assoc){
                if($assoc->users_id == $user->id){
                    foreach($tasks as $task){
                        if($assoc->tasks_id == $task->id){
                            if($task->alarmdate!=null){
                                if(Carbon::now()->gte(Carbon::parse($task->alarmdate))){
                                    $diff = Carbon::now()->diffForHumans(Carbon::parse($task->alarmdate));
                                    $task->alarmdate=null;
                                    $task->save();
                                    Notification::send($user,new NotifyUser($task->title, $diff, $task->id, $user->id)); 
                                    event(new MessageNotification('Neue Benachrichtigung erhalten', $user->id));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
