@extends('admin.auth.master')
@section('title', 'login')
@section('content')
    <div class="login-form">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('admin.password.email') }}">
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="au-input au-input--full @error('email') is-invalid @enderror"
                       name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <button class="au-btn au-btn--block au-btn--green m-b-20"
                    type="submit">{{ __('Send Password Reset Link') }}</button>
        </form>
    </div>
@endsection


