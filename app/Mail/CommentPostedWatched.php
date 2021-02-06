<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPostedWatched extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $comment;
    public $user;
    public function __construct(Comment $comment,User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject  = "comment add on {$this->comment->commentable->title} blog post";

        return $this->from('admin@laravel.test','Admin')  //if you don't want to use the default
            ->subject($subject)
            ->markdown('emails.post.comments-on-watch');
    }
}
