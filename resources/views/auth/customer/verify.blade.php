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
                                <span>Verify Email</span>
                            </div>
                            <span>The code has been sent to your email. </span><br>
                            <span>{{ !empty(session('email')) ? session('email') : '' }}</span><br>
                            <span>Please check your email.</span>
                            <form method="post" action="{{ route('customer.verify') }}">
                                @csrf
                                <div class="input-box">
                                    <input type="hidden" name="email" value="{{ !empty(session('email')) ? session('email') : '' }}">
                                    <div class="single-input-fields">
                                        <label for="code">Enter your code to continue</label>
                                        <input type="text"
                                               class="form-control input-font {{ classInvalid('code', $errors) }}"
                                               id="code" name="code"
                                               value="{{ oldValue('code') }}">
                                        {!! showErrorHtml('code', $errors) !!}
                                    </div>
                                    <div class="single-input-fields">
                                        <button type="submit" class="submit-btn3">Verify</button>
                                    </div>
                                </div>
                                <!-- form Footer -->
                                <div class="register-footer">
                                    <p> You have not received the code? <a href="javascript:void(0)"> Resend</a>
                                        here</p>
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
