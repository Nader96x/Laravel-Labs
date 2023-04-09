<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->paginate(5);
        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = Post::with('user')->find($id);
        #dd($post);
        return new PostResource($post);
    }


    public function store(StorePostRequest $request)
    {
        $request->only(['title', 'description', 'posted_by', 'image']);
        $request->validated();
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->posted_by;
        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('images', 'public');
        }
        $post->save();
        return new PostResource($post);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post)
            if ($post->image && Storage::disk('public')->exists($post->image))
                Storage::disk('public')->delete($post->image);
        $post->delete();

        return redirect()->route('posts.index');
    }

    public function restore()
    {
        $posts = Post::onlyTrashed()->restore();
        return redirect()->route('posts.index');
    }

}
