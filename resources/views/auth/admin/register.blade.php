@extends('admin.auth.master')
@section('title', 'login')
@section('content')
    <div class="login-form">
        <form method="POST" action="{{ route('admin.register') }}">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input id="name" type="text" class="au-input au-input--full @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email"
                       class="au-input au-input--full @error('email') is-invalid @enderror" name="email"
                       value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password"
                       class="au-input au-input--full @error('password') is-invalid @enderror" name="password"
                       required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="au-input au-input--full"
                       name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="login-checkbox">
                <label>
                    <input type="checkbox" name="aggree">Agree the terms and policy
                </label>
            </div>
            <button class="au-btn au-btn--block au-btn--blue m-b-20" type="submit">{{ __('Register') }}</button>
            <div class="social-login-content">
                <div class="social-button">
                    <button class="au-btn au-btn--block au-btn--blue m-b-20">register with facebook</button>
                    <button class="au-btn au-btn--block au-btn--blue2">register with twitter</button>
                </div>
            </div>
        </form>
        <div class="register-link">
            <p>
                Already have account?
                <a href="{{ route('admin.form-login') }}">Sign In</a>
            </p>
        </div>
    </div>
@endsection
