<?php

Route::view('/', 'front.pages.index');
Route::get('/category/{slug}', 'Front\CategoryController@show')->name('category.show');
Route::get('/product/{slug}', 'Front\ProductController@show')->name('product.show');
require 'admin.php';
Route::post('/product/add/cart', 'Front\ProductController@addToCart')->name('product.add.cart');

Route::get('/checkout', 'Front\CheckoutController@getCheckout')->name('checkout.index');

Route::get('/cart', 'Front\CartController@getCart')->name('checkout.cart');
Route::get('/cart/item/{id}/remove', 'Front\CartController@removeItem')->name('checkout.cart.remove');
Route::get('/cart/clear', 'Front\CartController@clearCart')->name('checkout.cart.clear');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
