
@extends('layouts.app')
@section('title')Post No. {{$post['id']}} @endsection

@section('content')
    <h1 class="mt-5 text-center text-decoration-underline">Post No. {{$post['id']}}</h1>
    <div class="card">
        <div class="card-header">
            <h3>{{$post['title']}}</h3>
        </div>
        <div class="card-body">
            <p>{{$post['description']}}</p>
        </div>
        <div class="card-footer">
            <p>Posted by: {{$post['posted_by']}}</p>
            <p>Created at: {{$post['created_at']}}</p>
        </div>
    </div>
@endsection
