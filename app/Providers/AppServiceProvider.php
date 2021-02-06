<?php

namespace App\Providers;

use App\Http\ViewComposer\ActivityComposer;
use App\Models\BlogPost;
use App\Observers\BlogpostObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\Comment as CommentResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      //  Blade::component('badge', Badge::class);

//        View::composer('posts.index',ActivityComposer::class);   you may also put it here
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['posts.index','posts.show'],ActivityComposer::class);

        BlogPost::observe(BlogpostObserver::class);
        //Schema::defaultStringLength(191);

//        RateLimiter::for('sending',function ($job){
//            return Limit::perMinute(2);
//        });

        CommentResource::withoutWrapping();
//        ResourceCollection::withoutWrapping();
//        JsonResource::withoutWrapping();
    }
}
