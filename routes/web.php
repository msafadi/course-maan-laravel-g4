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

Route::get('/admin/categories', 'Admin\CategoriesController@index')
    ->name('admin.categories.index');

Route::get('/admin/categories/create', 'Admin\CategoriesController@create')
    ->name('admin.categories.create');

Route::post('/admin/categories', 'Admin\CategoriesController@store')
    ->name('admin.categories.store');

Route::get('/admin/categories/{id}', 'Admin\CategoriesController@edit')
    ->name('admin.categories.edit');

Route::put('/admin/categories/{id}', 'Admin\CategoriesController@update')
    ->name('admin.categories.update');

Route::delete('/admin/categories/{id}', 'Admin\CategoriesController@destroy')
    ->name('admin.categories.destroy');