<?php

use Illuminate\Support\Facades\Route;
//$domain = config('settings.domain.shop');

Route::prefix('vietnam-zone')->name('vietnam_zone.')->group(function () {
    Route::get('/tinh-thanh-pho', 'VietnamZoneController@getProvince');
    Route::get('/quan-huyen', 'VietnamZoneController@getDistrict');
    Route::get('/phuong-xa', 'VietnamZoneController@getWard');
    Route::get('/tim-dia-chi', 'VietnamZoneController@addressByGso');
    Route::get('/province', 'VietnamZoneController@getProvince')->name('province');
    Route::get('/district', 'VietnamZoneController@getDistrict')->name('district');
    Route::get('/ward', 'VietnamZoneController@getWard')->name('ward');
    Route::get('/address-by-gso', 'VietnamZoneController@addressByGso')->name('address_by_gso');
    Route::post('/billing-shipping-fee', 'VietnamZoneController@billingShippingFee')->name('billing_shipping_fee');
});
