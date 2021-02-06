<?php

namespace App\Http\Controllers;

use App\Models\Tag;


class PostTagController extends Controller
{
    public function index ( $id ) {
        $tag = Tag::with('blogPosts')->findOrFail($id);
//        $post = BlogPost::with(['tags'=>function(Builder $q ) use ($id){
//            $q->where('tag_id','',$id);
//        }])->get();//->has('id','=',$id);
//        //dd($post);
        return view('posts.index',[
            'posts' =>$tag->blogPosts()
                                    ->withAll()
                                    ->get(),
            ]);
    }
}
