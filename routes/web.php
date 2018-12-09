<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('prepaid-balance', 'PrepaidController');
Route::resource('product', 'ProductCommController');
Route::get('/order', 'OrderController@index')->name('order');
Route::get('/order-confirmation', 'OrderController@orderConfirmation')->name('order-confirmation');
Route::get('/payment/{order_number}', 'PaymentController@index')->name('payment');
Route::get('/payment', 'PaymentController@payment')->name('payment');
Route::post('/payment-submit', 'PaymentController@paymentAction')->name('paymentsubmit');
