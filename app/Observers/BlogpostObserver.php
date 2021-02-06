<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogpostObserver
{
    public function updating(BlogPost $blogPost)
    {
        Cache::forget('ThePost-'.$blogPost->id);
    }

    public function deleting(BlogPost $blogPost)
    {
        $blogPost->comments()->delete();
        Cache::forget('ThePost-'.$blogPost->id);
    }

    public function restoring(BlogPost $blogPost)
    {
        $blogPost->comments()->restore();
    }
}
