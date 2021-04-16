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

/*
GET
POST
PUT
PATCH
DELETE
*/

Route::get('/', function() {
    return view('welcome');
});

Route::group([
    'prefix' => '/admin',
    'namespace' => 'Admin',
    'as' => 'admin.',
], function() {

    Route::group([
        'prefix' => '/categories',
        //'namespace' => 'Admin',
        'as' => 'categories.',
    ], function() {

        Route::get('/', 'CategoriesController@index')->name('index');
        Route::get('/create', 'CategoriesController@create')->name('create');
        Route::post('/', 'CategoriesController@store')->name('store');
        Route::get('/{id}', 'CategoriesController@edit')->name('edit');
        Route::put('/{id}', 'CategoriesController@update')->name('update');
        Route::delete('/{id}', 'CategoriesController@destroy')->name('destroy');

    });

    // Resource Route and Controller
    Route::get('posts/trash', 'PostsController@trash')->name('posts.trash');
    Route::put('posts/{id}/restore', 'PostsController@restore')->name('posts.restore');
    Route::delete('posts/trash/{id}', 'PostsController@forceDelete')->name('posts.force-delete');

    Route::resource('posts', 'PostsController')->names([
        //'index' => 'admin.posts.index',
        //'show' => 'admin.posts.show',
    ]);

    Route::get('posts/{id}/image', 'PostsController@image')->name('posts.image');

});

Route::get('articles', 'PostsController@index')->name('articles.index');
Route::get('articles/{id}', 'PostsController@show')->name('articles.show');