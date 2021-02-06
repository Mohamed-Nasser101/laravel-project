<?php

namespace App\Models;

use App\Scope\DeletedAdminScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Taggable;

    protected $table = "blog_posts";                //     expected table name if the table doesn't follow laravel conventions
    protected $fillable = ['title','content','user_id'];

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable')->latest();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT,'desc');
    }

    public function scopeMostCommentted(Builder $query )
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeWithAll(Builder $q)
    {
        return $q->latest()->withCount('comments')->with('user')->with('tags');
    }

    public static function boot() {      // model events

        static::addGlobalScope(new DeletedAdminScope());  //register the scope

        parent::boot();

//        static::deleting( function ( BlogPost $blogpost ) {
//            $blogpost->comments()->delete();
//            Cache::forget('ThePost-'.$blogpost->id);
//        });
//        static::restoring ( function ( BlogPost $blogpost ) {
//            $blogpost->comments()->restore();
//        });
//
//        static::updating(function (BlogPost $post){
//            Cache::forget('ThePost-'.$post->id);
//        });

    }
}
