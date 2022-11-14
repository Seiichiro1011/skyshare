<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Auth;

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


Auth::routes();


Route::group(['prefix'=> 'admin','as'=>'admin.','middleware'=>'admin'],function(){
    // user
    Route::get('/users',[UsersController::class,'index'])->name('users');
    Route::delete('/users/{id}/deactivate',[UsersController::class,'deactivate'])->name('users.deactivate');
    Route::patch('/users/{id}/activate',[UsersController::class,'activate'])->name('users.activate');
    // post
    Route::get('/posts',[PostsController::class,'index'])->name('posts');
    Route::delete('/posts/{id}/hide',[PostsController::class,'hide'])->name('posts.hide');
    Route::patch('/posts/{id}/unhide',[PostsController::class,'unhide'])->name('posts.unhide');
    // emotion
    Route::get('/categories',[CategoriesController::class,'index'])->name('categories');
    Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}/delete',[CategoriesController::class,'destroy'])->name('categories.destroy');
    Route::patch('/categories/{id}/update',[CategoriesController::class,'update'])->name('categories.update');

});

// middleware is for check the requests across the site
Route::group(['middleware'=>'auth'],function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/suggestions', [HomeController::class, 'suggestions'])->name('suggestions');
    Route::get('/search', [HomeController::class, 'search'])->name('search');

    // Post
    Route::group(['prefix'=>'post','as'=>'post.'],function(){
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::post('/store', [PostController::class, 'store'])->name('store');
    Route::get('/{id}/show', [PostController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
    Route::patch('/{id}/update',[PostController::class,'update'])->name('update');
    Route::delete('/{id}/delete',[PostController::class,'destroy'])->name('destroy');

});
// Comment
Route::group(['prefix'=>'comment','as'=>'comment.'],function(){
    Route::post('/{post_id}/store',[CommentController::class,'store'])->name('store');
    Route::delete('/{post_id}/delete',[CommentController::class,'destroy'])->name('destroy');
});
// Profile
Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('profile/update',[ProfileController::class,'update'])->name('profile.update');
Route::patch('profile/update_pass',[ProfileController::class,'updatePass'])->name('profile.updatePass');
Route::get('/profile/{id}/followers',[ProfileController::class,'followers'])->name('profile.followers');
Route::get('/profile/{id}/following',[ProfileController::class,'following'])->name('profile.following');

// like
Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
Route::delete('/like/{post_id}/destroy',[LikeController::class,'destroy'])->name('like.destroy');


// follow
Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
Route::delete('/follow/{user_id}/destroy',[FollowController::class,'destroy'])->name('follow.destroy');

});
