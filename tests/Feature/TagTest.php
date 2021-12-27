<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tag;
class TagTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_model(){
        $tag = Tag::factory()->create();
        $this->assertModelExists($tag);
        $tag->delete();
    }

    
    public function test_create_tag(){
        $tag = Tag::create([
            'name' => 'testTag',
            'users_id' => 5
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'testTag'
        ]);
        $this->assertDatabaseHas('tags', [
            'users_id' => 5
        ]);

        $tag->delete();
    }
    
    public function test_read_tag(){
        $tag = Tag::create([
            'name' => 'testTag',
            'users_id' => 5
        ]);

        
        $this->assertDatabaseHas('tags', [
            'name' => 'testTag',
        ]);

        $tag->delete();

    }

    public function test_update_tag(){
        $tag = Tag::create([
            'name' => 'testTag',
            'users_id' => 5
        ]);

        $tag->name= 'newTag';
        $tag->save();
        $this->assertDatabaseHas('tags', [
            'name' => 'newTag',
        ]);

        $tag->delete();
        
    }

    public function test_delete_tag(){
        $tag = Tag::factory()->count(1)->create();
        $tag = Tag::first();

        $tag->delete();
        $this->assertDeleted($tag);
    }
}
