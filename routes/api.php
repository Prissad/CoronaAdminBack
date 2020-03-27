<?php

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

/*
Route::post('/signup', 'AdminController@signUp');

Route::post('login', 'AdminController@login');
*/
Route::get('/hello','PostsController@index');
Route::post('/rep','PostsController@store');

Route::get('/posts', 'PostsController@show2');
Route::put('/edit' , 'PostsController@edit2');
Route::get('/search','PostsController@search');


Route::post('/signup', 'AdminController@register');
Route::post('/login', 'AdminController@login');
Route::post('/logout', 'AdminController@logout');
