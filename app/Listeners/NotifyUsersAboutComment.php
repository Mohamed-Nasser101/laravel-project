<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyPostWasCommented;
use App\Mail\PostCommenttedMarkdown;
use Illuminate\Support\Facades\Mail;

class NotifyUsersAboutComment
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        Mail::to($event->comment->commentable->user)->queue(new PostCommenttedMarkdown($event->comment));
        NotifyPostWasCommented::dispatch($event->comment);
    }
}
