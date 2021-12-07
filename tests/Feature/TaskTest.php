<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_model(){
        $task = Task::factory()->create();
        $this->assertModelExists($task);
        $task->delete();
    }

    
    public function test_create_task(){
        $task = Task::create([
            'title' => 'testTask',
            'description' => 'testdescription'
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'testTask'
        ]);
        $this->assertDatabaseHas('tasks', [
            'description' => 'testdescription'
        ]);

        $task->delete();
    }
    
    public function test_read_task(){
        $task = Task::create([
            'title' => 'testTask',
            'description' => 'testdescription'
        ]);

        
        $this->assertDatabaseHas('tasks', [
            'title' => 'testTask'
        ]);

        $task->delete();

    }

    public function test_update_task(){
        $task = Task::create([
            'title' => 'testTask',
            'description' => 'testdescription'
        ]);

        $task->title= 'newTitle';
        $task->save();
        $this->assertDatabaseHas('tasks', [
            'title' => 'newTitle',
        ]);

        $task->delete();
        
    }

    public function test_delete_task(){
        $task = Task::factory()->count(1)->create();
        $task = Task::first();

        $task->delete();
        $this->assertDeleted($task);
    }


}
