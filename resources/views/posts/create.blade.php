@extends('app')

@section('title', 'create posts')

@section('content')
    <div class="form-container">
        <div class="form-header">New Post</div>

        <div class="form-body">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="title">Title</label>

                    <div>
                        <input id="title" type="text" class="form-textbox @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                        @error('title')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">

                    <input id="file" type="file" class="form-file @error('title') is-invalid @enderror" name="file" value="{{ old('file') }}" required autocomplete="file" autofocus>

                    @error('file')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror

                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>

                    <div>
                        <textarea id="description" class="form-textarea @error('description') is-invalid @enderror"  rows="10" name="description" value="{{ old('description') }}" required autocomplete="description"></textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="form-submit">
                            Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
