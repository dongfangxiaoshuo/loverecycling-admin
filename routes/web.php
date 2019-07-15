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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/get_index','Home\IndexController@index');
Route::get('/get_index_informations','Home\IndexController@index_type');
Route::get('/category','Home\CategoryController@index');
Route::get('/category/productInformation','Home\CategoryController@productInformation');