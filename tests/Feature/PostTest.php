<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;   // refresh the database so it's empty every time you run the test
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testWhenThereIsPostAvailable()
    {
        $user = $this->user();
        $this->actingAs($user);
        $post = $this->createPost($user->id);
        $response = $this->get('/posts');
        $response->assertSeeText('new title');
        $this->assertDatabaseHas('blog_posts',[
           'content'=>'new post content'
        ]);
    }

    public function testNoPostThere()
    {
        $user = $this->user();
        $this->actingAs($user);
        $response = $this->get('/posts');
        $response->assertSeeText('No posts yet');
    }

    public function testStoreValid()
    {
        $user = $this->user();
        $this->actingAs($user);

        $params = [
            'title'=>'valid title',
            'content'=>'some content to add',
            'user_id' => $user->id,
        ];

        $this->post('/posts',$params)
            ->assertStatus(302)
            ->assertSessionHas('status');
        $this->assertEquals(session('status'),'new post added');
    }

    public function testStoreFailure()
    {
        $params = [
            'title'=>'x',
            'content'=>'x'
        ];

        $this->actingAs($this->user())
                ->post('/posts',$params)
                ->assertStatus(302)
                ->assertSessionHas('errors');
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 5 characters.');
    }

    public function testUpdatePost()
    {
        $user = $this->user();
        $post = $this->createPost($user->id);

        $this->assertDatabaseHas('blog_posts',[
              "id" => $post->id,
              "title" => "new title",
              "content" => "new post content",
              "user_id" => $user->id,

        ]);

        $params = [
            'title'=>'new title updated',
            'content'=>'new post content updated',
        ];

        $this->actingAs($user)
                ->put("/posts/{$post->id}",$params)
                ->assertStatus(302)
                ->assertSessionHas('status');
        $this->assertEquals(session('status'),'post updated');
        $this->assertDatabaseMissing('blog_posts',$post->toArray());
        // you may add database has assertion here
    }

    public function testDeletePost()
    {
        $user = $this->user();
        $post = $this->createPost($user->id);

        $this->actingAs($user)
                ->delete("/posts/{$post->id}")
                ->assertStatus(302)
                ->assertSessionHas('status');
        //$this->assertDatabaseMissing('blog_posts',$post->toArray());
        $this->assertSoftDeleted('blog_posts',$post->toArray());
    }

    public function testPostWithNoComment()
    {
        $user = $this->user();
        $post = $this->createPost( $user->id);
        $this->actingAs($user);
        $response  = $this->get('/posts');
        $response->assertSeeText('no comments');
        $response->assertSeeText('new title');
        $this->assertDatabaseHas('blog_posts',[
            'title'=>'new title',
            'content'=>'new post content'
        ]);
    }

    public function testPostWithComments()
    {
        $user = $this->user();
        $post = $this->createPost($user->id);
        $this->actingAs($user);
        Comment::factory()->count(4)->create([
            'commentable_id' => $post->id,
            'commentable_type' => BlogPost::class,
            'user_id' => $user->id
        ]);
        $this->actingAs($this->user());
        $response  = $this->get('/posts');
        $response->assertSeeText('4 comments');
    }

    private function createPost( $param = null) : BlogPost{

//        $post = new BlogPost();
//        $post->title='new title';
//        $post->content = 'new post content';
//        $post->save();
//        return $post;

        return BlogPost::factory()->titleContent()->create([
            'user_id' => $param ?? $this->user()->id
        ]);   //use state to produce certain content
    }
}
