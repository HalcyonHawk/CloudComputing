@extends('layouts.app')

@section('content')

<div class="container">
    @if (Auth::check())
    <button href="{{ route('post.create') }}">Create Post</button>
    @endif
    @if ($posts->count())
    @foreach ($posts as $post)
    <div class="card">
        <div class="card-header">
            <h3><a href="{{ route('post.show', ['post' => $post->post_id]) }}">
                {{ $post->title }}</a></h3>

            <div class="float-right">
                {{ $post->LastEditedFormatted }}
                <!--User can only edit their own post-->
                @if ($post->user_id == Auth::user()->user_id)
                <button href="{{ route('post.edit', ['post' => $post->post_id]) }}" 
                    class="btn btn-primary">Edit<button>
                <form action="{{ route('post.destroy', ['post' => $post->post_id])}}"
                    method="POST">
                    {{ csrf_field() }}
                    {{ method_field('Delete') }}
                    <button onclick="return confirm('Are you sure?');" 
                        type="submit" class="btn btn-primary">Remove</button>
                </form>
                @endif
            </div>
        </div>
        <div class="card-body">
            {{ $post->content }}
        </div>
    </div>
    @endforeach
    @else
    <div class="alert alert-info">
        No posts yet.
    </div>
    @endif
</div>
@endsection
