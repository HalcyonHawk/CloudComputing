@extends('layouts.app')

@section('content')

<div class="container">
    @auth
    @if (Auth::user()->role == "admin")
    <a class="btn btn-primary" href="{{ route('post.create') }}">Create Post</a>
    <div class="py-2"></div>
    @endif
    @endauth
    @if ($posts->count())
    @foreach ($posts as $post)
    <div class="card">
        <div class="card-header">
            <h3><a href="{{ route('post.show', ['post' => $post->post_id]) }}">
                {{ $post->title }}</a></h3>

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
            <img src="{{ "https://laravel-blog-images.s3.amazonaws.com/" . $post->file_link . ".jpg" }}">
            @endif

            {{ $post->content }}
        </div>
    </div>
    <div class="py-2"></div>
    @endforeach
    @else
    <div class="alert alert-info">
        No posts yet.
    </div>
    @endif
</div>
@endsection
