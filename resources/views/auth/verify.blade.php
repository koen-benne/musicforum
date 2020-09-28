@extends('app')

@section('content')
<div class="form-container">
    <div class="form-header">{{ __('Verify Your Email Address') }}</div>

    <div class="form-body">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="form-submit">{{ __('click here to request another') }}</button>.
        </form>
    </div>
</div>
@endsection
