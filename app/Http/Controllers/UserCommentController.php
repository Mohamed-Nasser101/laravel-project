<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\User;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store( StoreComment $request,User $user )
    {
        $user->commentsOn()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
            //'user_id' => Auth::user()->id,
        ]);
        return redirect()->back()->withStatus('comment added');
    }
}
