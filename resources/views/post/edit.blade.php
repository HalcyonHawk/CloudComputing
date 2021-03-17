@extends('layouts.app')

@section('content')

<div class="container">
<div class="card">
    <div class="card-header"><h3>Edit Post</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('post.update', ['post' => $post->post_id]) }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group row">
                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                <div class="col-md-6">
                    <input type="text" style="text-transform: capitalize;" class="form-control" name="title" value="{{ $post->title }}" required autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="content" class="col-md-4 col-form-label text-md-right">{{ __('Content') }}</label>

                <div class="col-md-6">
                    <textarea id="content" class="form-control" style="resize: none;" rows="6" name="content" required>{{ $post->content }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="photo_link" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                <div class="col-md-6">
                    <input id="photo_link" type="file" name="photo_link">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
</div>
@endsection