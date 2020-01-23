<?php

Route::namespace('Admin')
    ->prefix('admin')
    ->as('admin.')
	->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('dashboard');
        Route::get('/settings', 'SettingController@index')->name('settings.index');
        Route::post('/settings', 'SettingController@update')->name('settings.update');
        Route::resource('categories', 'CategoryController');
        Route::resource('brands', 'BrandController');
        Route::post('products/images/upload', 'ProductImageController@upload')->name('products.images.upload');
        Route::get('products/images/{id}/delete', 'ProductImageController@destroy')->name('products.images.delete');
        Route::resource('products', 'ProductController');
        Route::resource('attributes', 'AttributeController');

        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', 'OrderController@index')->name('orders.index');
            Route::get('/{order}/show', 'OrderController@show')->name('orders.show');
        });


});
