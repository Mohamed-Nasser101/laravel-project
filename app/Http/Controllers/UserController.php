<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRquest;
use App\Models\Image;
use App\Models\User;
use App\Services\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(User::class,'user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $counter = new Counter();
        return view('user.show',[
            'user'=>$user,
            'counter' => $counter->increment("user-{$user->id}"),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit',['user' =>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRquest $request, User $user)
    {
        if ($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('avatar');

                    if ($user->image){
                    Storage::delete($user->image->path);
                    $user->image->path = $path;
                    $user->image->save();
                    } else {
                        $user->image()->save(Image::make(['path' => $path]));
                    }
        }

            $name = $request->input('name');
            $user->name = $name;
            $user->save();
//            $request->session()->flash('status','user updated');
//            return redirect()->route('users.show',['user' => $user->id]);
            return redirect()->route('users.show',['user' => $user->id])->withStatus('user updated');

    }
}
