<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;
use App\Models\BlogPost;


class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(BlogPost $post)
    {
        return $post->comments()->with('user')->get();
    }

    public function store( StoreComment $request,BlogPost $post )
    {
        //$validated = $request->validated();
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

       // Mail::to($post->user)->send(new PostCommenttedMarkdown($comment));

        event(new CommentPosted($comment));

//        Mail::to($post->user)->queue(new PostCommenttedMarkdown($comment));

//        $when = now()->addMinutes(1);
//        Mail::to($comment->user)->later($when,new PostCommenttedMarkdown($comment));

    //    NotifyPostWasCommented::dispatch($comment);   moved to event listener

        $request->session()->flash('status','comment added');
        return redirect()->back();
    }
}
