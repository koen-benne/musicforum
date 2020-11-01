@extends('app')

@section('title', 'edit user')

@section('content')
    <div class="form-container">
        <div class="form-header">Edit Post</div>

        <div class="form-body">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Username</label>

                    <div>
                        <input id="name" type="text" class="form-textbox @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?: $user->name }}" required autocomplete="name" autofocus>

                        @error('name')
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
