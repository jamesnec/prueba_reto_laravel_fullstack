<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'WebController@index')->name('index');

//--------------------- Unauthorized Routes  ---------------------------------
Route::get('register', function () {
    return redirect()->to('/');
})->name('register');
Route::get('login', function () {
    return redirect()->to('/');
})->name('login');
Route::get('/home', function () {
    return redirect()->to('/');
});

//---------------------Authentication Routes  ---------------------------------
Route::get('login/user', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//--------------------- Administration Routes ---------------------------------
Route::get('/administrador', 'HomeController@administrator')->name('administrator');


//--------------------- API Endpoints Admin Routes ---------------------------------
Route::get('/api/exchanges', 'ExchangeController@index')->name('exchanges/all');
Route::post('/api/exchanges', 'ExchangeController@store')->name('exchanges/store');
Route::put('/api/exchange/{id}', 'ExchangeController@update')->name('exchanges/update');
Route::delete('/api/exchange/{id}', 'ExchangeController@destroy')->name('exchanges/destroy');

//--------------------- API Endpoints Front-End Routes ---------------------------------
Route::get('/api/exchanges/list', 'ExchangeController@list')->name('exchanges/list');
Route::post('/api/exchange/convert', 'ExchangeController@convert')->name('exchanges/convert');
