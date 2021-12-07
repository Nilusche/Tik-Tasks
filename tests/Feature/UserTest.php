<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_routes(){
        $response = $this->get('/login');
        $response->assertStatus(200);
    }


    public function test_model(){
        $user = User::factory()->create();
        $this->assertModelExists($user);
        $user->delete();
    }

    

    public function test_create_user(){
        $user = User::create([
            'name' => 'nilusche',
            'email' => 'nilusche@mail.com'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'nilusche@mail.com',
        ]);

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'email' => 'nilusche@mail.com',
        ]);

    }

    public function test_read_user(){

        $user = User::create([
            'name' => 'nilusche',
            'email' => 'nilusche@mail.com'
        ]);
        $this->assertNotFalse()
        $this->assertDatabaseHas('users', [
            'email' => 'nilusche@mail.com',
        ]);


    }

    public function test_update_user(){
        $user = User::create([
            'name' => 'nilusche',
            'email' => 'nilusche@mail.com'
        ]);

        $user->email= 'test@gmail.com';
        $user->save();
        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
        ]);

        $user->delete();
        
    }

    public function test_delete_user(){
        $user = User::factory()->count(1)->create();
        $user = User::first();

        $user->delete();
        $this->assertDeleted($user);
    }
    

}
