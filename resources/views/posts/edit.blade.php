@extends('app')

@section('title', 'edit posts')

@section('content')
<div class="form-container">
    <div class="form-header">Edit Post</div>

    <div class="form-body">
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label" for="title">Title</label>

                <div>
                    <input id="title" type="text" class="form-textbox @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?: $post->title }}" required autocomplete="title" autofocus>

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">

                <input id="file" type="file" class="form-file @error('title') is-invalid @enderror" name="file" value="{{  old('file') }}" autocomplete="file" autofocus>

                @error('file')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror

            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>

                <div>
                    <textarea id="description" class="form-textarea @error('description') is-invalid @enderror"  rows="10" name="description" autocomplete="description">{{ old('description') ?: $post->description }}</textarea>

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="tags">Tags</label>

                <div>
                    <input name="tags" id="tags" type="text" class="form-textbox @error('tags') is-invalid @enderror" name="tags" value="{{ old('tags') ?: implode(', ', $post->tags()->pluck('tagname')->all()) }}" required autocomplete="title" autofocus>

                    @error('title')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="form-submit">
                    Edit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
