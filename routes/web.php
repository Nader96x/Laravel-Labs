<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PostsContoller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [PostsContoller::class,'index'])->name('posts.index');
Route::get('/posts', [PostsContoller::class,'index'])->name('posts.index');
Route::get('/posts/create', [PostsContoller::class,'create'])->name('posts.create');
Route::post('/posts', [PostsContoller::class,'store'])->name('posts.store');
Route::delete('/posts/{id}', [PostsContoller::class,'destroy'])->name('posts.destroy');
Route::get('/posts/{id}/edit', [PostsContoller::class,'edit'])->name('posts.edit');
Route::put('/posts/{id}', [PostsContoller::class,'update'])->name('posts.update');
//Route::post('/posts/{id}', [PostsContoller::class,'update'])->name('posts.update');

Route::get('/posts/{id}', [PostsContoller::class,'show'])->name('posts.show');


