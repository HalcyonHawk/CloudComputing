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

Route::group(['middleware' => 'auth'], function () {
    //Only admin users can manage posts
    Route::resource('post', 'PostController')->only([
        'create', 'store', 'edit', 'update', 'destroy'
    ]);

    //All logged in users can comment
    Route::resource('post.comment', 'CommentController')->only([
        'create', 'store', 'destroy'
    ]);
});

//Anyone visting the site can view posts
Route::resource('post', 'PostController')->only([
    'index', 'show'
]);

Auth::routes();

//Website home page
Route::get('/', 'PostController@index');