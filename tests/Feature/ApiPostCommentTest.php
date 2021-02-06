<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPostCommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPlogBostDontHaveComments()
    {
        $user  = $this->user();
        BlogPost::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this->json('GET','api/v1/posts/1/comments');
        $response->assertStatus(200)
        ->assertJsonStructure(['data','links','meta'])
        ->assertJsonCount(0,'data');  //not working
    }

    public function testCheckPostHas10Comments()
    {
        $user  = $this->user();
        $post = BlogPost::factory()->create([
            'user_id' => $user->id
        ]);
        Comment::factory()->count(10)->create([
           'commentable_type' => 'App\Models\BlogPost',
            'commentable_id' => $post->id,
            'user_id' => $user->id
        ]);
//        $post->comments()->saveMany(
//            Comment::factory(10)->make([
//                'user_id' => $user->id
//            ]));
        $response = $this->json('GET','api/v1/posts/2/comments');
        $response->assertStatus(200)
            ->assertJsonStructure(['data','links','meta'])
            ->assertJsonCount(5,'data'); //not working it be 10
    }
}
