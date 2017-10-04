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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::get('/threads', 'ThreadsController@index');

Route::get('/threads/create', 'ThreadsController@create');

Route::get('/threads/{channel}', 'ThreadsController@index');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');

Route::post('/threads', 'ThreadsController@store');

//Route::resource('threads', 'ThreadsController');

Route::post('replies/{reply}/favorites', 'FavoritesController@store');

Route::get('duc', function () {
    $collection = collect([1, 2, 3, 4]);

    $filtered = $collection->map(function ($value, $key) {
//        return $value > 2;
        if ($value > 2) {
            return $value;
        }
    });

//    $filtered = $collection->filter(function ($value, $key) {
//        return $value > 2;
//    });

    return $filtered->all();
});