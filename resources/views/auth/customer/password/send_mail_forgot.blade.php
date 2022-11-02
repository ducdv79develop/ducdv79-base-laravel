@extends('frontend.layouts.master')
@section('title', 'Quên mật khẩu')
@section('content')
    @include('frontend.common.breadcrumb', ['breadcrumbs' => [
        ['title' => 'Quên mật khẩu', 'url' => null]
    ]])
    <section class=" margin-top-0">
        <div class="container">
            <div class="page_title">
                <h1 class="title_page_h1 text-center">Đặt lại mật khẩu
                </h1>
            </div>
            <div class="customer-form row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3 nopadding-xs">
                    <form accept-charset="utf-8" action="{{ route('customer.forgot_password') }}" id="customer_forgot_password" method="post">
                        @csrf
                        <p>Chúng tôi sẽ gửi cho bạn một email để kích hoạt việc đặt lại mật khẩu.</p>

                        <div class="form-signup error margin-bottom-15">

                        </div>
                        <label for="email">Email<span class="required">*</span></label>
                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="input-control" value="" title="email" name="email" id="email">
                        <p class="action-btn">
                            <input type="submit" class="button_all" value="Gửi"> hoặc
                            <a href="{{ route('customer.login') }}" id="cancel_forgot_password">Hủy</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
