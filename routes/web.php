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

Route::middleware('auth')->group( function () {
    Route::get('/site/{site}/', 'SiteController@show');
});

Route::get('/track/', 'ViewController@track');


/*
 |--------------------------------------------------------------------------
 | Cookie-based API routes
 |--------------------------------------------------------------------------
 |
 | These routes are for the web-app API. They don't need formal auth and
 | just use cookie auth
 |
 */

 Route::group( [ 'prefix' => '/api/v1', 'middleware' => 'auth' ], function () {
    
    Route::get('/site/{site}/top-pages/week', 'TopPagesApiController@showWeek');
    Route::get('/site/{site}/top-pages', 'TopPagesApiController@show');

 } );