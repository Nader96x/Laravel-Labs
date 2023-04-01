@extends('layouts.app')

@section('title') Edit Post @endsection

@section('content')
    <form method="POST" action="{{route('posts.update',$post['title'])}}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$post['id']}}">
        <div class="m-3">
            <label class="form-label">Title</label>
            <input  name="title" type="text" class="form-control" value="{{$post['title']}}">
        </div>
        <div class="m-3">
            <label  class="form-label">Description</label>
            <textarea name="description" class="form-control"  rows="3">{{$post['description']}}</textarea>
        </div>

        <div class="m-3">
            <label class="form-label">Post Creator</label>
            <select name="posted_by" class="form-control">
                <option @if($post['posted_by']=="Nader")selected @endif value="Nader">Nader</option>
                <option @if($post['posted_by']=="Ahmed")selected @endif value="Ahmed">Ahmed</option>
                <option @if($post['posted_by']=="Mohamed")selected @endif value="Mohamed">Mohamed</option>
            </select>
        </div>

        <button class="m-3 btn btn-success">Submit</button>
    </form>
@endsection
