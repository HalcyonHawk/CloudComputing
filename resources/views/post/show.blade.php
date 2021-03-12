@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{ $post->title }}</h3>
            <div class="float-right">{{ $post->LastEditedFormatted }}</div>
        </div>
        <div class="card-body">
            {{ $post->content }}

            <br>
            <!--Display comments on the post-->
            @if ($post->comment != null)
            @foreach ($post->comment as $comment)
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ $comment->user->name }}</h3>
                            <div class="float-right">
                                {{ $comment->LastEditedFormatted }}
                                <!--User can delete their own comment only-->
                                @if ($comment->user_id == Auth::user()->user_id)
                                <form action="{{ route('comment.destroy', ['comment' => $comment->comment_id])}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('Delete') }}
                                    <button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-primary">Remove</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $comment->content }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="alert alert-info">
                No comments.
            </div>
            @endif

            <!--Display button to add comment if user is logged in-->
            @if (Auth::check())
            <button href="{{ route('comment.create', ['post' => $post->post_id]) }}">
                Add Comment</button>
            @endif
        </div>
    </div>
</div>
@endsection
