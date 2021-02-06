<?php

namespace App\Jobs;

use App\Mail\CommentPostedWatched;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyPostWasCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

//    public function middleware()
//    {
//        return [new RateLimited('sending')];
//    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::thatHasCommented($this->comment->commentable)->get()
            ->filter(function (User $user){
                return $user->id !== $this->comment->user_id;
            })->map(function (User $user){
                Mail::to($user)->send(new CommentPostedWatched($this->comment,$user));
            });
    }
}
