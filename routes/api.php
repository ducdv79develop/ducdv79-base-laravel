<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::fallback(function(){
    return response()->json(['message' => 'Không tìm thấy trang. Nếu lỗi vẫn còn, hãy liên hệ với developteamshoplm@gmail.com'], 404);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('google-driver')->name('google_driver.')->group(function () {
    Route::get('get-image', 'GoogleDriverController@getImage')->name('get_image');
    Route::post('upload-image', 'GoogleDriverController@uploadImage')->name('upload_image');
    Route::post('delete-image', 'GoogleDriverController@deleteImage')->name('delete_image');
});
