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

// Route::get('/', function () {
//     return view('welcome');
// });

//url shortener

Route::GET('/shortener', 'LinkController@index');

Route::POST('/store', 'LinkController@store');

//Blog

Route::resource('posts', 'PostController');
Route::resource('bits', 'BitsController');

Route::GET('/', 'PostController@index')->name('home');

Route::POST('/posts/{post}/comments', 'CommentsController@store');

Route::get('/posts/tags/{tag}', 'TagsController@index');

Route::get('/get/categories', 'AjaxController@getCategories');

Auth::routes(['verify' => true ]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');

