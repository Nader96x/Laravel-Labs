<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;


class PostsContoller extends Controller
{
    public function index(){
        $posts = Post::paginate(5);
        return view('posts.index',['posts'=>$posts]);
    }
    public function show($id){
        $post = Post::find($id);;
        return view('posts.show',['post'=>$post]);
    }
    public function create(){
        $users = User::all();
        return view('posts.create',['users'=>$users]);
    }
    public function store(StorePostRequest $request){
        $request->only(['title','description','posted_by','image']);
        $request->validated();

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->posted_by,


        ]);
//        $post = $post->replicate();
//        $post->save();

        return redirect()->route('posts.index');
    }
    public function destroy($id){
        $post = Post::find($id);
        if($post)
            $post->delete();
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
            $post->save();
        }
        return redirect()->route('posts.index');
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
        return response()->json([
            'post' => $post,
            'user' => $post->user,
            'comments' => $post->comments,
        ]);
    }
}
