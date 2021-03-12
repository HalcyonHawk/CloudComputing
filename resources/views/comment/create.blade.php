@extends('layouts.app')

@section('content')

<div class="container">
<div class="card">
    <div class="card-header"><h3>Add Comment</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('comment.store') }}">
            @csrf

            <div class="form-group row">
                <label for="content" class="col-md-4 col-form-label text-md-right">{{ __('Content') }}</label>

                <div class="col-md-6">
                    <textarea id="content" class="form-control" style="resize: none;" rows="2" name="content" required>{{ old('content') }}</textarea>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
</div>
@endsection
