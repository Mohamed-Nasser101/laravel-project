<?php

namespace App\Models;

use App\Scope\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory , SoftDeletes ,Taggable;

    public $fillable = ['content','user_id'];
    protected $hidden = ['deleted_at','commentable_id','commentable_type','user_id'];

//    public function blogPost()
//    {
//        return $this->belongsTo(BlogPost::class);
//    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT,'desc');
    }

    public static function boot() {      // model events
        parent::boot();
       // static::addGlobalScope(new LatestScope() );  //register the scope

        static::creating(function (Comment $comment){
            if ($comment->commentable_type === BlogPost::class){
                Cache::forget('ThePost-'.$comment->commentable_id);
                Cache::forget('mostCommented');
            }
        });
    }
}
