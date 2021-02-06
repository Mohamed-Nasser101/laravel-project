<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect(['sports','entertainment','hoppies','politics','science','economy']);
        $tags->each(function ($tagName){
            $tag = new Tag();
            $tag->name = $tagName;
            $tag->save();
        });
    }
}
