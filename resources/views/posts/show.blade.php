
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
            <p>Posted by: {{$post->user->name}}</p>
            <p>Created at: {{$post->human_readable_date}}</p>
        </div>
    </div>
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                <div class="card-body p-4">
                    <div class="form-outline mb-4">
                        <form method="POST" action="{{route('posts.add_comment',$post['id'])}}">
                            @csrf
                            <input name="comment" type="text" id="addANote" class="form-control" placeholder="Type your comment..." />
                            <input type="submit" class="form-control btn btn-success mt-3" value="comment" />
                        </form>
                    </div>
                    @foreach($post->comments as $comment)
                        <div class="card my-2">

                            <div class="card-body">
                                <p>{{$comment->comment}}</p>
{{--                                <p>Posted by: {{$comment->user->name}}</p>--}}

                                <div class="d-flex justify-content-end">
                                    <input type="hidden" name="comment_id" value="{{$comment['id']}}" />
                                    <a href="{{route('posts.edit_comment',$post['id'])}}"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary mx-3 edit">edit</a>
{{--                                    <form method="POST" action="{{route('posts.edit_comment',$post['id'])}}">--}}
{{--                                        <input type="hidden" name="comment_id" value="{{$comment['id']}}" />--}}
{{--                                        <input type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary mx-3 edit" value="edit" />--}}
{{--                                    </form>--}}

                                    <form method="POST" action="{{route('posts.delete_comment',$post['id'])}}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="comment_id" value="{{$comment['id']}}" />
                                        <input type="submit" class="btn btn-danger" value="delete" />
                                    </form>
                                </div>
                            </div>
                        </div>


                    @endforeach

                </div>
            </div>
        </div>
    </div>

@endsection
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-edit" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="comment_id" id="comment_id" value="" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">comment:</label>
                        <textarea name="comment" class="form-control" id="message-text"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        let exampleModal = document.getElementById('exampleModal')
        let btns = document.getElementsByClassName('edit');
        for (const btn of btns) {
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                // debugger;
                console.log(event.target.parentElement.children[0].value);
                let url = event.target.href;
                let comment = event.target.parentElement.parentElement.querySelector("p").innerText;
                let id = event.target.parentElement.querySelector("input[name='comment_id']").value;
                // debugger;
                exampleModal.querySelector("input[name='comment_id']").value = id;
                exampleModal.querySelector("textarea[name='comment']").innerHTML = comment;
                exampleModal.querySelector('#form-edit').action = url;
            })
        }
    });
</script>
