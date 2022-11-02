<?php
// Replace admin with whatever prefix you need
use Illuminate\Support\Facades\Route;

// Patterns
Route::pattern('id', '\d+');
Route::pattern('hash', '[a-z0-9]+');
Route::pattern('hex', '[a-f0-9]+');
Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->domain(env('WEBSITE_DOMAIN_ADMIN'))->name('admin.')->group(function () {

    Route::namespace('Auth\Admin')->group(function () {
        Route::get('login', 'LoginController@showLoginForm')->name('form_login');
        Route::post('login', 'LoginController@login')->name('login');
        Route::middleware('admin')->group(function () {
            Route::post('logout', 'LoginController@logout')->name('logout');
            Route::post('/my-profile/{id}/change-pass', 'ChangePasswordController@changePass')->name('profile.change_pass');
        });
    });

    Route::namespace('Admin')->middleware('admin')->group(function () {
        Route::get('home', 'HomeController@index')->name('home');

        /*
        |--------------------------------------------------------------------------
        | Analyse Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('analyse')->name('analyse.')->namespace('Analyse')->group(function () {
            Route::get('/', 'AnalyseController@index')->name('index');
        });

        /*
        |--------------------------------------------------------------------------
        | Admin Member Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('member')->name('member.')->namespace('Management')->group(function () {
            Route::middleware(middlePermission(hasRead(PER_GROUP_ADMIN)))->group(function () {
                Route::get('/', 'AdminController@index')->name('index');
                Route::get('/find-by-id', 'AdminController@findByID')->name('find_by_id');
                Route::get('/{id}/profile', 'AdminController@profile')->name('profile');
            });
            Route::middleware(middlePermission(hasWrite(PER_GROUP_ADMIN)))->group(function () {
                Route::post('/create', 'AdminController@create')->name('create');
                Route::post('/update', 'AdminController@update')->name('update');
            });
        });
        /*
        |--------------------------------------------------------------------------
        | My Profile Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('my-profile')->name('profile.')->namespace('Management')->group(function () {
            Route::get('/', 'MyProfileController@index')->name('index');
            Route::post('{id}/update', 'MyProfileController@update')->name('update');
            Route::post('change-avatar', 'MyProfileController@changeAvatar')->name('change_avatar');
        });
        /*
        |--------------------------------------------------------------------------
        | Role Permission Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('role')->name('role.')->namespace('Management')->group(function () {
            Route::middleware(middleRoleOrPer([ROLE_SYSTEM_MANAGEMENT, hasRead(PER_GROUP_ROLE)]))->group(function () {
                Route::get('/', 'RoleController@index')->name('index');
                Route::get('/get-by-code', 'RoleController@getByCode')->name('get_by_code');
            });
            Route::middleware(middleRoleOrPer([ROLE_SYSTEM_MANAGEMENT, hasWrite(PER_GROUP_ROLE)]))->group(function () {
                Route::post('/create', 'RoleController@create')->name('create');
                Route::post('/update', 'RoleController@update')->name('update');
            });
        });

        Route::prefix('permission')->name('permission.')->namespace('Management')->group(function () {
            Route::middleware(middleRoleOrPer([ROLE_SYSTEM_MANAGEMENT, hasRead(PER_GROUP_ROLE)]))->group(function () {
                Route::get('/', 'PermissionController@index')->name('index');
                Route::get('/get-by-code', 'PermissionController@getByCode')->name('get_by_code');
            });
            Route::middleware(middleRoleOrPer([ROLE_SYSTEM_MANAGEMENT, hasWrite(PER_GROUP_ROLE)]))->group(function () {
                Route::post('/create', 'PermissionController@create')->name('create');
                Route::post('/update', 'PermissionController@update')->name('update');
            });
        });
    });
});
