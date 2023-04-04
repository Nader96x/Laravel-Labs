<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostsContoller extends Controller
{
    public function index(){
        $posts = Post::paginate(5);
        return view('posts.index',['posts'=>$posts]);
    }
    public function show($id){
        $post = Post::find($id);
//        $post->image = asset('storage/'.$post->image);
        return view('posts.show',['post'=>$post]);
    }
    public function create(){
        $users = User::all();
        return view('posts.create',['users'=>$users]);
    }
    public function store(StorePostRequest $request){
        $request->only(['title','description','posted_by','image']);
        $request->validated();
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->posted_by;
//        $post->image = $request->image;
        if($request->hasFile('image')){
            $post->image = $request->file('image')->store('images','public');
        }
//        dd($request->image,$post->image);
        $post->save();

//        $post = $post->replicate();
//        $post->save();
//        return redirect()->route('posts.index');
        return redirect()->route('posts.show',['id'=>$post->id]);
    }
    public function destroy($id){
        $post = Post::find($id);
        if($post)
            if ($post->image && Storage::disk('public')->exists($post->image))
                Storage::disk('public')->delete($post->image);
            $post->delete();


//        return redirect()->back();
        return redirect()->route('posts.index');
    }
    public function restore(){
        $posts = Post::onlyTrashed()->restore();
        return redirect()->route('posts.index');
    }
    public function edit($id){
        $post = Post::find($id);
        $users = User::all();
        if($post)
            return view('posts.edit',['post'=>$post,'users'=>$users]);
        return redirect()->route('posts.index');
    }
    public function update(UpdatePostRequest $request){
        $post = Post::find($request->id);
        if($post){
            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = $request->posted_by;
            $prev_image = $post->image?explode('storage/',$post->image)[1]:null;
//            $post->image = $request->image;
            if($request->hasFile('image')){
                $post->image = $request->file('image')->store('images','public');
            }
            $post->save();
            if(
                $prev_image
                && Storage::disk('public')->exists($prev_image)
            ){

                Storage::disk('public')->delete($prev_image);
            }

        }
        return redirect()->route('posts.show',['id'=>$request->id]);
//        return redirect()->route('posts.index');
    }

    public function add_comment($id,Request $request){
        $post = Post::find($id);
        if($post){
            $post->comments()->create([
                'comment' => $request->comment,
                'user_id' => 1,
            ]);
        }
        return redirect()->route('posts.show',['id'=>$request->id]);
    }
    public function delete_comment($id,Request $request){
        $post = Post::find($id);
        if($post){
            $post->comments()->where('id',$request->comment_id)->delete();
        }
        return redirect()->route('posts.show',['id'=>$request->id]);
    }
    public function edit_comment($id,Request $request){
        $post = Post::find($id);
        if($post){
            $post->comments()->where('id',$request->comment_id)->update([
                'comment' => $request->comment,
            ]);
        }
        return redirect()->route('posts.show',['id'=>$request->id]);
    }
    public function details($id){
        $post = Post::find($id);
        /*if($post->image)
            $post->image = asset('storage/'.$post->image);*/
        return response()->json([
            'post' => $post,
            'user' => $post->user,
            'comments' => $post->comments,

        ]);
    }
}
