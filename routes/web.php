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

Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => 'auth'], function () {
    //Only admin users can manage posts
    Route::group(['middleware' => 'role'], function () {
        Route::resource('posts', 'PostController')->only([
            'create', 'store', 'update', 'destroy'
        ]);
    });

    //All logged in users can comment
    //Shallow means that a post id is not needed for show, edit, update, destroy
    Route::resource('posts.comments', 'CommentController')->only([
        'create', 'store', 'destroy'
    ])->shallow();
});

//Anyone visting the site can view posts
Route::resource('posts', 'PostController')->only([
    'index', 'show'
]);
