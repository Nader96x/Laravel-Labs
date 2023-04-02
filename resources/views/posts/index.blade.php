@extends('layouts.app')
@section('title', 'Posts')

@section('content')
    <h1 class="mt-5 text-center text-decoration-underline">Posts</h1>
<div class="table-responsive">
    <table class="table table-dark table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Body</th>
            <th>Publisher</th>
            <th>created at</th>
            <th>Updated at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)

            <tr>
                <td>{{$post['id']}}</td>
                <td>{{$post['title']}}</td>
                <td>{{$post['description']}}</td>
                <td>{{$post->user->name}}</td>
                <td>{{$post['created_at']}}</td>
                <td>{{$post['updated_at']}}</td>
                <td>
                    <a href="{{route('posts.show',$post['id'])}}" class="btn btn-info">View</a>
                    <a href="{{route('posts.edit',$post['id'])}}" class="btn btn-primary">Edit</a>
                    <a href="{{route('posts.destroy',$post['id'])}}"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="delete btn btn-danger">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Post No.<span id="post_id"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    are you sure you want to delete this post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form id="form-delete" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    window.addEventListener('load', function () {
        let btns = document.getElementsByClassName('delete');
        for (const btn of btns) {
            btn.addEventListener('click', function (event) {
                console.log(event.target.href);
                let url = event.target.href;
                let id = url.substring(url.lastIndexOf('/') + 1);
                document.getElementById('post_id').innerHTML = id;
                document.querySelector('#form-delete').action = url;

            })
        }
    });
</script>
