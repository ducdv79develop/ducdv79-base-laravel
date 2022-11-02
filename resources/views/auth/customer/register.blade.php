@extends('auth.user.master')
@section('title', 'login')
@section('content')
    <main class="login-bg">
        <!-- Register Area Start -->
        <div class="register-form-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="register-form text-center">
                            <div class="register-heading">
                                <span>Sign Up</span>
                            </div>
                            <form method="post" action="{{ route('customer.register') }}">
                                @csrf
                                <div class="input-box">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="single-input-fields">
                                                <label for="surname">Surname</label>
                                                <input type="text"
                                                       class="form-control input-font {{ classInvalid('surname', $errors) }}"
                                                       id="surname" name="surname"
                                                       value="{{ oldValue('surname') }}">
                                                {!! showErrorHtml('surname', $errors) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-input-fields">
                                                <label for="name">Name</label>
                                                <input type="text"
                                                       class="form-control input-font {{ classInvalid('name', $errors) }}"
                                                       id="name" name="name"
                                                       value="{{ oldValue('name') }}">
                                                {!! showErrorHtml('name', $errors) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-input-fields">
                                        <label for="email">Email Address</label>
                                        <input type="text"
                                               class="form-control input-font {{ classInvalid('email', $errors) }}"
                                               id="email" name="email"
                                               value="{{ oldValue('email') }}">
                                        {!! showErrorHtml('email', $errors) !!}
                                    </div>
                                    <div class="single-input-fields">
                                        <label for="phone">Phone Number</label>
                                        <input type="text"
                                               class="form-control input-font {{ classInvalid('phone', $errors) }}"
                                               id="phone" name="phone"
                                               value="{{ oldValue('phone') }}">
                                        {!! showErrorHtml('phone', $errors) !!}
                                    </div>
                                    <div class="single-input-fields">
                                        <label for="password">Password</label>
                                        <input type="password"
                                               class="form-control input-font {{ classInvalid('password', $errors) }}"
                                               id="password" name="password">
                                        {!! showErrorHtml('password', $errors) !!}
                                    </div>
                                    <div class="single-input-fields">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control input-font" id="password_confirmation"
                                               name="password_confirmation">
                                    </div>
                                </div>
                                <!-- form Footer -->
                                <div class="register-footer">
                                    <p> Already have an account? <a href="{{ route('customer.form-login') }}"> Login</a>
                                        here</p>
                                    <button type="submit" class="submit-btn3">Sign Up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Area End -->
    </main>
@endsection
