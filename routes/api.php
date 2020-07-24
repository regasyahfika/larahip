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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/kategori', 'KategoriController@index');
Route::post('/kategori/store', 'KategoriController@store');
Route::get('/kategori/{id?}', 'KategoriController@show');
Route::post('/kategori/update/{id?}', 'KategoriController@update');
Route::delete('/kategori/{id?}', 'KategoriController@destroy');

Route::get('/posts', 'PostsController@index');
Route::post('/posts/store', 'PostsController@store');
Route::get('/posts/{id?}', 'PostsController@show');
Route::post('/posts/update/{id?}', 'PostsController@update');
Route::delete('/posts/{id?}', 'PostsController@destroy');

Route::get('/transaksi', 'TransaksiController@index');
Route::get('/transaksi/{id?}', 'TransaksiController@show');

