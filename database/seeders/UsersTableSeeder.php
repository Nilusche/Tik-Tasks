<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use\App\Models\User;
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
    }
}
