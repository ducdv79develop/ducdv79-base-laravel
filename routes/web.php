<?php

use App\Helpers\GoogleDriveHelpers;
use Illuminate\Support\Facades\Route;
use Faker\Factory;

// Patterns
Route::pattern('id', '\d+');
Route::pattern('hash', '[a-z0-9]+');
Route::pattern('hex', '[a-f0-9]+');
Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::prefix('/customer')->name('customer.')->namespace('Auth\Customer')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('form_login');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/logout', 'LoginController@logout')->middleware('customer')->name('logout');

    Route::get('/redirect/facebook', 'FacebookController@redirect')->name('redirect_facebook');
    Route::get('/callback/facebook', 'FacebookController@callback');
    Route::get('/redirect/google', 'GoogleController@redirect')->name('redirect_google');
    Route::get('/callback/google', 'GoogleController@callback');

    Route::get('/register', 'RegisterController@showRegisterForm')->name('form_register');
    Route::post('/register', 'RegisterController@register')->name('register');

    Route::get('/forgot-password', 'ForgotPasswordController@showForgotPasswordForm')->name('form_forgot_password');
    Route::post('/forgot-password', 'ForgotPasswordController@forgotPassword')->name('forgot_password');
    Route::get('{token}/reset-password', 'ForgotPasswordController@showResetPasswordForm')->name('form_reset_password');
    Route::post('{token}/reset-password', 'ForgotPasswordController@resetPassword')->name('reset_password');
});

Route::name('frontend.')->domain(config('settings.domain.shop'))->namespace('Frontend')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/contact', 'ContactController@index')->name('contact');
    Route::post('/contact-us', 'ContactController@contactUs')->name('contact_us');

    Route::prefix('/account')->name('account.')->middleware('customer')
        ->namespace('MyPage')->group(function () {
        Route::get('/', 'MyPageController@index')->name('info');
        Route::get('/order', 'MyPageController@order')->name('order');
        Route::get('/change-password', 'MyPageController@changePassword')->name('change_password');
        Route::get('/address', 'MyPageController@address')->name('address');
    });

});

Route::get('test-json', function () {
    $fake = Factory::create('vi_VN');
    $arr = [];
    for($i = 0; $i < 10; $i++) {
        $arr[$fake->text(10)] = [
            'name' => $fake->name(),
            'age' => $fake->numerify('##'),
            'phone' => $fake->numerify('0#########'),
        ];
    }

    return json_encode($arr);
});
