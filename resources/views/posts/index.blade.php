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
            <th>Slug</th>
            <th>Body</th>
            <th>Publisher</th>
            <th>created at</th>
            <th>Updated at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)

{{--            @dd($post['created_at']);--}}
            <tr>
                <td>{{$post['id']}}</td>
                <td>{{$post['title']}}</td>
                <td>{{$post['slug']}}</td>
                <td>{{$post['description']}}</td>
                <td>{{$post->user->name}}</td>
                <td title="{{$post['created_at']->isoFormat('Do-MMMM-YYYY, h:mm:ss A')}}">{{$post['created_at']->diffForHumans()}}</td>
                <td>{{$post['updated_at']}}</td>
                <td>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#postModal" data-id="{{ $post->id }}">Details</button>
                    <a href="{{route('posts.show',$post['id'])}}" class="btn btn-info">View</a>
                    <a href="{{route('posts.edit',$post['id'])}}" class="btn btn-primary">Edit</a>
                    <a href="{{route('posts.destroy',$post['id'])}}"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="delete btn btn-danger">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination justify-content-center">
        {{ $posts->links() }}
    </div>
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

    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="post-description"></p>
                    @if($post->image)
                        <p><img src="{{$post->image}}" alt="{{$post['description']}}" width="250em" height="250em"></p>
                    @endif
                    <hr>
                    <p class="post-author"></p>
                    <p class="post-author-email"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const postModal = document.getElementById("postModal");
            postModal.addEventListener("show.bs.modal", function(event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const postId = button.dataset.id; // Extract post ID from data-id attribute
                const modal = event.target;
                modal.querySelector(".modal-title").textContent = "Post #" + postId;

                // Sen'd fetch request to get post info
                fetch('{{route('posts.details',':postId')}}'.replace(':postId', postId))
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.json();
                    })
                    .then(function(data) {
                        modal.querySelector(".modal-title").textContent = data.post.title;
                        modal.querySelector(".post-description").textContent = data.post.description;
                        modal.querySelector(".post-author").textContent = "Author: " + data.user.name;
                        modal.querySelector(".post-author-email").textContent = "Author Email: " + data.user.email;
                    })
                    .catch(function(error) {
                        console.error("Fetch error:", error);
                    });
            });
        });

    </script>
@endsection

