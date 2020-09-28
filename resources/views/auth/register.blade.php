@extends('app')

@section('content')
<div class="form-container">
    <div class="form-header">{{ __('Register') }}</div>

    <div class="form-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">{{ __('Name') }}</label>

                <div>
                    <input id="name" type="text" class="form-textbox @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>

                <div>
                    <input id="email" type="email" class="form-textbox @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>

                <div>
                    <input id="password" type="password" class="form-textbox @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

                <div>
                    <input id="password-confirm" type="password" class="form-textbox" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group">
                <div>
                    <button type="submit" class="form-submit">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
