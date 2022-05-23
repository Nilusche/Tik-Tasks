<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user=User::where('email', 'admin@gmail.com')->first();
        $user1= User::where('email', 'manager@gmail.com')->first(); 
        $user2 = User::where('email', 'worker@gmail.com')->first();
        /*
        Test-Accountdaten
        $user3 = User::where('email', 'worker2@gmail.com')->first();
        $user4 = User::where('email', 'worker3@gmail.com')->first();
        $user5 = User::where('email', 'worker4@gmail.com')->first();
        $user6 = User::where('email', 'worker5@gmail.com')->first();
        $user7 = User::where('email', 'worker6@gmail.com')->first();*/
        if(!$user){
            User::create([
                'name' =>'testadmin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' =>Hash::make('password')

            ]);
        }

        if(!$user1){
            User::create([
                'name' =>'testmanager',
                'email' => 'manager@gmail.com',
                'role' => 'manager',
                'password' =>Hash::make('password')

            ]);
        }
        if(!$user2){
            User::create([
               'name' => 'testworker',
               'email' => 'worker@gmail.com',
               'role' => 'worker',
               'password' => Hash::make('password')
            ]);
        }
        /*
        if(!$user3){
            User::create([
               'name' => 'testworker2',
               'email' => 'worker2@gmail.com',
               'role' => 'worker',
               'password' => Hash::make('password')
            ]);
        }
        if(!$user4){
            User::create([
               'name' => 'testworker3',
               'email' => 'worker3@gmail.com',
               'role' => 'worker',
               'password' => Hash::make('password')
            ]);
        }
        if(!$user5){
            User::create([
               'name' => 'testworker4',
               'email' => 'worker4@gmail.com',
               'role' => 'worker',
               'password' => Hash::make('password')
            ]);
        }
        if(!$user6){
            User::create([
               'name' => 'testworker5',
               'email' => 'worker5@gmail.com',
               'role' => 'worker',
               'password' => Hash::make('password')
            ]);
        }
        if(!$user7){
            User::create([
               'name' => 'testworker6',
               'email' => 'worker6@gmail.com',
               'role' => 'worker',
               'password' => Hash::make('password')
            ]);
        }*/
    }
}
