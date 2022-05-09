<?php

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
// I think, better replace to Home controller welcome func.
Route::get('/',  [App\Http\Controllers\PostController::class, 'welcome'])->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
// Add part category
Route::get('/posts/category/{category}', [App\Http\Controllers\PostController::class, 'posts'])->name('posts');
// You have a category, but don't use it.
//Route::get('/posts/{slug}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');

//    Read about this construction. We add it for post, except show if you want to use slug (->except(['show'])). Use Post $post in function.
//    It has name too, like "posts.create" and you can add middlewares in controller, in construct func except show and index Find in laravel doc.
Route::resources('posts', \App\Http\Controllers\PostController::class)->except(['show']);

// You can write in array your middlewares/
// Use prefix admin to add another admin routes.
Route::middleware(['auth', 'role:admin'])->prefix('/admin')->group(function () {


    Route::resources('posts', \App\Http\Controllers\PostController::class)->except(['show', 'index']);
// Route::get('/create', [App\Http\Controllers\PostController::class, 'create'])->name('post.create');
// Route::post('/store', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
// Route::get('/edit/{post:id}', [App\Http\Controllers\PostController::class, 'edit'])->name('post.edit');
// Route::patch('/update/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('post.update');
// Route::delete('/delete/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.delete');
//    Use admin. in name in admins routes.
 Route::get('posts/posts', [App\Http\Controllers\PostAdminController::class, 'index'])->name('admin.post.index');
 Route::get('posts/{post}', [App\Http\Controllers\PostAdminController::class, 'show'])->name('admin.post.show');
//  change it in controller use Post $post.
 Route::get('posts/{post}/tags', [App\Http\Controllers\TagController::class, 'create'])->name('admin.tags.create');
 Route::post('posts/{post}/tags', [App\Http\Controllers\TagController::class, 'store'])->name('admin.tags.store');
 Route::delete('posts/{post}/tags/{id}', [App\Http\Controllers\TagController::class, 'destroy'])->name('admin.tags.delete');
});

Auth::routes(['register' =>false, 'reset' => false, 'verify' => false]);

