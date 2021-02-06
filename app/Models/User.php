<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'email',
        'email_verified_at',
        'current_team_id',
        'profile_photo_path',
        'created_at',
        'updated_at',
        'is_admin',
        'profile_photo_url'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentsOn()
    {
        return $this->morphMany(Comment::class,'commentable')->latest();
    }

    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }

    public function scopeWithMostBlogPost( Builder $q)
    {
        return $q->withCount('blogPosts')->orderBy('blog_posts_count','desc');
    }

    public function scopeMostActiveLastMonth(Builder $q)
    {
         return $q->withCount(['blogPosts' =>function(Builder $query){   //add filter to the posts
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1),now()]);
        }])->has('blogPosts','>=',2)
            ->orderBy('blog_posts_count','desc');
    }

    public function scopeThatHasCommented(Builder $query ,BlogPost $blogPost)
    {
        return $query->whereHas('comments',function ($query) use ($blogPost){
            return $query->where('commentable_id','=',$blogPost->id)
                ->where('commentable_type' ,'=' ,BlogPost::class);
        });
    }

    public function scopeIsAdmin(Builder $query)
    {
        return $query->where('is_admin',true);
    }
}
