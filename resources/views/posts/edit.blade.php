@extends('layouts.app')

@section('title') Edit Post @endsection

@section('content')
    <form method="POST" action="{{route('posts.update',$post['title'])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$post['id']}}">
        <div class="m-3">
            <label class="form-label">Title</label>
            <input  name="title" type="text" class="form-control" value="{{$post['title']}}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="m-3">
            <label  class="form-label">Description</label>
            <textarea name="description" class="form-control"  rows="3">{{$post['description']}}</textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="m-3">
            <label  class="form-label">Image</label>
            @if($post['image'])
            <p><img src="{{$post->image}}" alt="" width="250em" height="250em" ></p>
            @endif
            <input  name="image" type="file" class="form-control" accept="image/*">
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        <div class="m-3">
            <label class="form-label">Post Creator</label>
            <select name="posted_by" class="form-control">
                @foreach( $users as $user)
                    <option @if($post['user_id']==$user['id'])selected @endif value="{{$user['id']}}">{{$user['name']}}</option>
                @endforeach

            </select>
            @error('posted_by')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="m-3 btn btn-primary">Save</button>
    </form>
@endsection
