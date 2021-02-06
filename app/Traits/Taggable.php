<?php
namespace App\Traits ;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

trait Taggable{
    protected static function bootTaggable()
    {
        static::updating(function ($model){
            $model->tags()->syncWithoutDetaching(static::findTagsInContent($model->content));
        });

        static::created(function ($model){
            $model->tags()->syncWithoutDetaching(static::findTagsInContent($model->content));
        });

    }
    public function tags()
    {
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps()->as('tagged');
    }

    private static function findTagsInContent($content){
        preg_match_all('/@([^@]+)@/m',$content,$tag);
        return Tag::whereIn('name',$tag[1] ?? [])->get();
    }
}
