@extends('layouts.app')

@section('title') New Post @endsection

@section('content')
    <form method="POST" action="{{route('posts.store')}}">
        @csrf
        <div class="m-3">
            <label class="form-label">Title</label>
            <input  name="title" type="text" class="form-control" value="New Movie">
        </div>
        <div class="m-3">
            <label  class="form-label">Description</label>
            <textarea name="description" class="form-control"  rows="3">New Movie Description</textarea>
        </div>

        <div class="m-3">
            <label  class="form-label">Post Creator</label>
            <select name="posted_by" class="form-control">
                @foreach($users as $user)
                    <option value="{{$user['id']}}">{{$user['name']}}</option>
                @endforeach
               {{-- <option value="Ahmed">Ahmed</option>
                <option value="Mohamed">Mohamed</option>--}}
            </select>
        </div>

        <button class="m-3 btn btn-success">Submit</button>
    </form>
@endsection
