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
Route::get('/signature/save' , 'Api\SignaturesController@save');

Route::get('/{any}', 'Api\HomeController@index')
    ->where('any', '^(?!auth|api|download|storage).*$');


//auth
Route::get('/auth/redirect' , 'Auth\LoginController@redirect')->name('auth');
Route::get('/auth/callback' , 'Auth\LoginController@callback');
Route::get('/auth/logout' , 'Auth\LoginController@logout');

Route::get('/download' , 'Api\MessagesController@download');



