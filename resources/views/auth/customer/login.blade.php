@extends('frontend.layouts.master')
@section('title', 'Đăng nhập')
@section('content')
    @include('frontend.common.breadcrumb', ['breadcrumbs' => [
        ['title' => 'Đăng nhập tài khoản', 'url' => null]
    ]])
    <section class=" margin-top-0">
        <div class="container">
            <div class="page_title">
                <h1 class="title_page_h1 text-center">Đăng nhập tài khoản
                </h1>
            </div>
            <div class="customer-form row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3 nopadding-xs">
                    <form accept-charset="utf-8" action="{{ route('customer.login') }}" id="customer_login" method="post">
                        @csrf
                        <p id="intro">Nếu bạn có một tài khoản, xin vui lòng đăng nhập</p>

                        <div class="social-login text-center margin-bottom-10">
                            <a href="{{ route('customer.redirect_facebook') }}" class="social-login--facebook">
                                <img width="129px" height="37px" alt="facebook-login-button" src="{{ asset('frontend/svg/fb-btn.svg') }}">
                            </a>
                            <a href="{{ route('customer.redirect_google') }}" class="social-login--google">
                                <img width="129px" height="37px" alt="google-login-button" src="{{ asset('frontend/svg/gp-btn.svg') }}">
                            </a>
                            <style>
                                .social-login a {
                                    display: inline-block;
                                }
                            </style>
                        </div>
                        <label for="customer_email">Email <span class="required">*</span></label>
                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                               class="input-control" name="email" id="customer_email">
                        <label for="customer_password">Mật khẩu <span class="required">*</span> </label>
                        <input type="password" class="input-control" name="password" id="customer_password">
                        <p class="action-btn">
                            <input type="submit" value="Đăng nhập" class="button_all">
                            <a href="{{ route('customer.form_forgot_password') }}" id="forgot_password" title="Mất mật khẩu?">Quên mật khẩu?</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
