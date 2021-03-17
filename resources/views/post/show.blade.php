@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{ $post->title }}</h3>
            <div class="float-right">
                <div class="btn-group">
                    {{ $post->LastEditedFormatted }}
                    <!--User can only edit their own post-->
                    @auth
                    @if (Auth::user()->role == "admin")
                    <a class="btn btn-primary" href="{{ route('post.edit', ['post' => $post->post_id]) }}" 
                        class="btn btn-primary">Edit<a>
                    <form action="{{ route('post.destroy', ['post' => $post->post_id])}}"
                        method="POST">
                        {{ csrf_field() }}
                        {{ method_field('Delete') }}
                        <button onclick="return confirm('Are you sure?');" 
                            type="submit" class="btn btn-primary">Remove</button>
                    </form>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($post->file_link != null)
            <img src="{{ "https://laravel-blog-images.s3.amazonaws.com/" . $post->file_link ".jpg" }}">
            @endif

            {{ $post->content }}
        </div>
    </div>

    <div class="py-2"></div>

    <!--Display comments on the post-->
    @if ($post->comments->count())
    @foreach ($post->comments as $comment)
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <b>{{ ($comment->user->role == "admin") ? "Admin" : $comment->user->name }}</b>
                    <div class="float-right">
                        <div class="btn-group">
                        {{ $comment->LastEditedFormatted }}
                        <!--User can delete their own comment only-->
                        @auth
                        @if ($comment->user_id == Auth::user()->user_id)
                        <form action="{{ route('post.comment.destroy', ['post' => $comment->post_id, 'comment' => $comment->comment_id])}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('Delete') }}
                            <button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-primary">Remove</button>
                        </form>
                        @endif
                        @endauth
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{ $comment->content }}
                </div>
            </div>
        </div>
    </div>
    <div class="py-2"></div>
    @endforeach
    @else
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="alert alert-info">
                No comments.
            </div>
        </div>
    </div>
    @endif

    <!--Display button to add comment if user is logged in-->
    @auth
    <a class="btn btn-primary" 
        href="{{ route('post.comment.create', ['post' => $post->post_id]) }}">
        Add Comment</a>
    @endauth
</div>
@endsection
