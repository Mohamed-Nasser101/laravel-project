<?php


namespace App\Http\ViewComposer;


use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('mostCommented',now()->addMinutes(60),function (){
            return BlogPost::mostCommentted()->take(5)->get();
        });

        $mostActive = Cache::remember('mostActive',60,function (){
            return User::withMostBlogPost()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::remember('mostActiveLastMonth',60,function (){
            return User::mostActiveLastMonth()->take(5)->get();
        });

        $view->with('mostCommented',$mostCommented);
        $view->with('mostActive',$mostActive);
        $view->with('mostActiveLastMonth',$mostActiveLastMonth);
    }
}
