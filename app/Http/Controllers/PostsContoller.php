<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostsContoller extends Controller
{
    private $posts = [
        [
            'id' => 1,
            'title' => 'Laravel',
            'description' => 'hello laravel',
            'posted_by' => 'Ahmed',
            'created_at' => '2023-04-01 10:00:00',
        ],

        [
            'id' => 2,
            'title' => 'PHP',
            'description' => 'hello php',
            'posted_by' => 'Mohamed',
            'created_at' => '2023-04-01 10:00:00',
        ],

        [
            'id' => 3,
            'title' => 'Javascript',
            'description' => 'hello javascript',
            'posted_by' => 'Mohamed',
            'created_at' => '2023-04-01 10:00:00',
        ],
    ];
    public function index(){
        $posts = Post::all();
        return view('posts.index',['posts'=>$posts]);
    }
    public function show($id){
//        $post = $this->posts[$id-1];
        $post = Post::find($id);;
        return view('posts.show',['post'=>$post]);
    }
    public function create(){
        $users = User::all();
        return view('posts.create',['users'=>$users]);
    }
    public function store(Request $request){
//        $post = [
//            'id' => $this->posts[count($this->posts)-1]['id']+1,
//            'title' => $request->title,
//            'description' => $request->description,
//            'posted_by' => $request->posted_by,
//            'created_at' => date('Y-m-d H:i:s'),
//        ];
//        array_push($this->posts,$post);
//        dd($this->posts);
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->posted_by,

        ]);
        return redirect()->route('posts.index');

    }
    public function destroy($id){
        $post = Post::find($id);
        if($post)
            $post->delete();
        return redirect()->route('posts.index');


    }
    public function edit($id){
        $post = Post::find($id);
        $users = User::all();
        if($post)
            return view('posts.edit',['post'=>$post,'users'=>$users]);
        return redirect()->route('posts.index');


    }
    public function update(Request $request){
//        foreach ($this->posts as $key => $post) {
//            if($post['id'] == $request->id){
//                $this->posts[$key]['title'] = $request->title;
//                $this->posts[$key]['description'] = $request->description;
//                $this->posts[$key]['posted_by'] = $request->posted_by;
//            }
//        }
        $post = Post::find($request->id);
        if($post){
            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = $request->posted_by;
            $post->save();
        }
        return redirect()->route('posts.index');


    }

}
