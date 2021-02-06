<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class,'myWelcome'])->name('home');
Route::get('/mywelcome', [HomeController::class,'myWelcome'])->name('mywelcome');
Route::get('/contact', [HomeController::class,'contact'])->name('contact');
Route::get('/secret', [HomeController::class,'secret'])->name('secret')->middleware('can:home.secret');
Route::resource('/posts', PostController::class);
//Route::post('posts/{post}/restore',[PostController::class,'restore'])->name('posts.restore');
Route::get('/posts/tag/{tag}',[PostTagController::class,'index'])->name('post.tag.index');
Route::resource('posts.comments',PostCommentController::class)->only('index','store');
Route::resource('users',UserController::class)->only('show','edit','update');
Route::resource('users.comment',UserCommentController::class)->only('store');
//Route::get('mailable',function (){
//    $comment = \App\Models\Comment::find(1);
//    return new \App\Mail\PostCommenttedMarkdown($comment);
//});

//Route::resource('posts.comments', 'PostCommentController')->only(['index', 'store']);
//Route::resource('users.comments', 'UserCommentController')->only(['store']);
//Route::resource('users', 'UserController')->only(['show', 'edit', 'update']);

// Route::get('mailable', function () {
//     $comment = App\comment::find(1);
//     return new App\Mail\CommentPostedMarkdown($comment);
// });

//Auth::routes();

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
