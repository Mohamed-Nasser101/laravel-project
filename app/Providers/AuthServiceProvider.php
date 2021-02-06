<?php

namespace App\Providers;


use App\Models\Comment;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\BlogPost' => 'App\policies\BlogPostPolicy',
        User::class => UserPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('home.secret',function ($user){
            return $user->is_admin;
        });

//        Gate::define('update-post',function ( $user, $post ) {
//            return $user->id === $post->user_id;
//        });
//
//        Gate::define('delete-post',function ( $user, $post ) {
//            return $user->id === $post->user_id;
//        });

//        Gate::define('update-post',[BlogPostPolicy::class,'update']);
//        Gate::define('delete-post',[BlogPostPolicy::class,'delete']);

        Gate::before( function($user,$ability) {
            if ($user->is_admin){
                return true;
            }
        });

//        Gate::after( function($user,$ability,$result) {
//            if ($user->is_admin)){
//                return true;
//            }
//        });
    }
}
