<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = BlogPost::all();
        $user = User::all();

         Comment::factory(150)->make()->each(function ($comment) use ($posts,$user) {
             $comment->user_id = $user->random()->id;
             $comment->commentable_type = BlogPost::class;
             $comment->commentable_id = $posts->random()->id;
             $comment->save();
    });

        Comment::factory(150)->make()->each(function ($comment) use ($user) {
            $comment->user_id = $user->random()->id;
            $comment->commentable_type = User::class;
            $comment->commentable_id = $user->random()->id;
            $comment->save();
        });
    }
}
