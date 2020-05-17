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


Route::get('user', 'Api\User\UserController@index');

//messages
Route::get('/user/{slug}/messages', 'Api\MessagesController@folderMess');



Route::get('/count/messages', 'Api\MessagesController@messagesTollsCount');
Route::get('/messages/{servicesFolder}', 'Api\MessagesController@index');
Route::get('/message/{uid}', 'Api\MessagesController@show');
Route::get('/messages/{filters}/{offset}', 'Api\MessagesController@filters');

Route::post('/user/folders/update' , 'Api\MessagesController@update');

Route::get('/store/messages' , 'Api\StoreMessagesController');

Route::get('/delete/{uid}/{message_id}', 'Api\MessagesController@delete');
Route::get('/favorite/{method}/{message_id}/{uid}', 'Api\MessagesController@favorite');

//user-folders
Route::get('/user/folders' , 'Api\FoldersController@index');

Route::get('/sentMessage/{uid}', 'Api\MessagesController@show'); //??????????????нужно создать SentMessagesController@show ?????????????
Route::get('/sentMessage/sending/{uid}', 'Api\MessagesController@sending'); //??????????????нужно создать SentMessagesController@show ?????????????
Route::post('/send-email', 'Api\SendEmailController@index');






