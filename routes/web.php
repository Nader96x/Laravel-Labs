<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

//group auth
//Route::group(['middleware' => ['auth']], function () {
Route::middleware(['auth'])->group(function () {
    Route::get('/', [PostsContoller::class,'index'])->name('posts.index');
    Route::get('/posts', [PostsContoller::class,'index'])->name('posts.index');
    Route::get('/posts/restore', [PostsContoller::class,'restore'])->name('posts.restore');
    Route::get('/posts/create', [PostsContoller::class,'create'])->name('posts.create');
    Route::post('/posts', [PostsContoller::class,'store'])->name('posts.store');
    Route::delete('/posts/{id}', [PostsContoller::class,'destroy'])->name('posts.destroy');

    Route::post('/posts/{id}/comments', [PostsContoller::class,'add_comment'])->name('posts.add_comment');
    Route::delete('/posts/{id}/comments', [PostsContoller::class,'delete_comment'])->name('posts.delete_comment');
    Route::put('/posts/{id}/comments', [PostsContoller::class,'edit_comment'])->name('posts.edit_comment');

    Route::get('/posts/{id}/edit', [PostsContoller::class,'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostsContoller::class,'update'])->name('posts.update');
    //Route::post('/posts/{id}', [PostsContoller::class,'update'])->name('posts.update');

    Route::get('/posts/{id}', [PostsContoller::class,'show'])->name('posts.show');
    Route::get('/post/{id}', [PostsContoller::class,'details'])->name('posts.details');
});

use Laravel\Socialite\Facades\Socialite;

#http://127.0.0.1:8000/auth/redirect
Route::get('/auth/github', function () {
    return Socialite::driver('github')->redirect();
});

#http://127.0.0.1:8000/auth/callback
Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->stateless()->user();

    $user = User::updateOrCreate([
//        'github_id' => $githubUser->id,
        'email' => $githubUser->email,
    ], [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
        'password'=>bcrypt('123456'),
        'github_token' => $githubUser->token,
        'github_refresh_token' => $githubUser->refreshToken,
    ]);

    Auth::login($user);

    return redirect('/posts');
});
#http://127.0.0.1:8000/auth/google/redirect
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();

});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();
//    dd($googleUser);
    $user = User::updateOrCreate([
//        'google_id' => $googleUser->id,
        'email' => $googleUser->email,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'password'=>bcrypt('123456'),
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
    ]);

    Auth::login($user);

    return redirect('/posts');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
