<?php

namespace App\Http\Controllers;

use App\Events\BlogPostPosted;
use App\Models\BlogPost;
use App\Models\Image;
use App\Services\Counter;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use function Sodium\increment;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        //passing posts with number of comments
        return view("posts.index",[
            'posts' => BlogPost::withAll()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        //you can use request->input();
        $validated['user_id'] = $request->user()->id;   //add user  id for the post

        $blogpost = BlogPost::create($validated);   //mass assignment to data using create method accept an array

        if ($request->hasFile('thumbnail')){
            $path  = $request->file('thumbnail')->store('thumbnails');
//            Image::create([
//                'path' => $path,
//                'blog_post_id' => $blogpost->id
//            ]);
            $blogpost->image()->save(
           //    Image::create(['path' => $path])   //when we defined one-one relationship
                Image::make(['path' => $path])  //to be able to use morph relationship
            );
        }

        // $file->store('thumbnails');
        // Storage::disk('public')->putFile('thumbnail',$file);
        // $file->storeAs('thumbnails',$blogpost->id.'.'.$file->guessClientExtension());
//           $name =  Storage::disk('public')->putFileAs('thumbnails',$file,$blogpost->id.'.'.$file->guessExtension());
//           dd(Storage::disk('public')->url($name));

        event(new BlogPostPosted($blogpost));

        $request->session()->flash('status','new post added');
        return redirect()->route('posts.show', ['post' => $blogpost->id]);  //access id using the create function
        //return redirect('/posts/'.$model->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|
     */
    public function show($id)  // add ((Request $request)) parameter if want to display flash messages
    {
        //$request->session()->reflash();  to use the previous flash method

//        return view('posts.show',['post'=> BlogPost::with(['comments' =>function($q) {
//            return $q->latest();
//        }])->findOrFail($id)]);   // or use just find

        $thePost = Cache::remember('ThePost-'.$id,60,function () use($id ){
            return BlogPost::with('comments'/*['comments' => function($q){
                $q->with('user'); }]*/ ,'tags','user','comments.user')
//                ->with('tags')
//                ->with('user')
//                ->with('comments.user')
                ->findOrFail($id);
        });
        /*$sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";
        $users = Cache::get($usersKey, []);
        $userUpdate = [];
        $views = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1){
                $views--;
            }else{
                $userUpdate[$session] = $lastVisit;
            }
        }
        if (!array_key_exists($sessionId,$users) || $now->diffInMinutes($users[$sessionId]) >=1 ){
            $views++;
        }
        $userUpdate[$sessionId] = $now;

        Cache::forever($usersKey,$userUpdate);

        if (!Cache::has($counterKey)){
            Cache::forever($counterKey,1);
        }else{
            Cache::increment($counterKey,$views);
        }

        $viewers = Cache::get($counterKey);*/

        $counter = new Counter();

        return view('posts.show',[
            'post'=> $thePost,
            'viewers' =>$counter->increment("blog-post-{$id}"),
        ]);   // or use just find
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

//        if (Gate::denies('update-post',$post) ) {
//            abort(403,'you can\'t edit this post');
//        }

        $this->authorize('update',$post);

        return view('posts.edit' , ['post' => $post ]);            //pass the data to the url
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('update',$post);

        $validated = $request->validated();
        $post->fill($validated);

        if ($request->hasFile('thumbnail')){
            $path  = $request->file('thumbnail')->store('thumbnails');
            if ($post->image){
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }else{
                $post->image()->save(
//                   Image::create(['path' => $path])   //when we defined one-one relationship
                    Image::make(['path' => $path])  //to be able to use morph relationship
                );
            }
        }
        $post->save();
        $request->session()->flash('status','post updated');
        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);
//        if (Gate::denies('update-post',$post) ) {
//            abort(403,'you can\'t delete this post');
//        }
        $this->authorize('delete',$post);
   //     $this->authorize($post);   you can even delete it completely

        $post->delete();
        $request->session()->flash('status','post deleted');
        return redirect()->route('posts.index');
       // BlogPost::destroy($id);  another way
    }

//    public function restore(BlogPost $post)
//    {
//        $post->restore();
//        return redirect()->route('posts.index')->withStatus('post restored');
//    }
}
