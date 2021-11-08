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
        $user=User::where('email', 'normalworker@gmail.com')->first();

        if(!$user){
            User::create([
                'name' =>'testworker',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' =>Hash::make('password')
                
            ]);
        }
    }
}
