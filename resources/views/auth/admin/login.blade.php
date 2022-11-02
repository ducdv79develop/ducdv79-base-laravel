@extends('auth.admin.master')
@section('title', __('auth.admin.title'))
@section('content')
    <div class="card-body">
        @if (session()->has(SESSION_FAIL))
            <p class="login-box-msg text-danger">{!! session()->get(SESSION_FAIL) !!}</p>
        @elseif (session()->has(SESSION_SUCCESS))
            <p class="login-box-msg text-success">{!! session()->get(SESSION_SUCCESS) !!}</p>
        @else
            <p class="login-box-msg">{{ __('auth.admin.msg') }}</p>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control @if(session()->has(SESSION_FAIL)) is-invalid @endif"
                       placeholder="{{ __('auth.admin.phone') }}"
                       name="phone" id="phone" value="{{ old('phone') }}"
                       required autocomplete="current-phone" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-phone"></span>
                    </div>
                </div>
                @error('phone')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control @if(session()->has(SESSION_FAIL)) is-invalid @endif"
                       placeholder="{{ __('auth.admin.password') }}"
                       name="password" id="password" required
                       autocomplete="current-password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <div class="row">
                <div class="col-7">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember" name="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            {{ __('auth.admin.remember') }}
                        </label>
                    </div>
                </div>
                <div class="col-5">
                    <button type="submit" class="btn btn-info btn-block">{{ __('auth.admin.title') }}</button>
                </div>
            </div>
        </form>
        <div class="social-auth-links text-center mt-2 mb-3">
            {{--<a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i> {{ __('auth.admin.login_facebook') }}
            </a>
            <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> {{ __('auth.admin.login_google') }}
            </a>--}}
        </div>
        <p class="mb-1">
            <a href="#">{{ __('auth.admin.forget') }}</a>
        </p>
        <p class="mb-0">
            <a href="#" class="text-center">{{ __('auth.admin.register') }}</a>
        </p>
    </div>
@endsection
