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

// Home page
Route::get('/', 'HomeController@index')->name('home-page');

Route::get('/add-to-black-list', 'Bitrix24Controller@addToBackList');
Route::post('/add-to-black-list', 'Bitrix24Controller@addToBackList');

Route::get('test', 'HomeController@test');

// Login page
Route::get('login', 'LoginController@index')->name('login-page');
Route::post('api/login', 'LoginController@login')->name('login-action');

Route::group(['middleware' => 'auth'], function () {
    // Profile page
    Route::post('search', 'SearchController@search')->name('search');
    Route::get('profile/parsers/{telephone}', 'ProfileController@profileOnlyParser')->name('profileOnlyParser');
    Route::get('profile/{telephone}', 'ProfileController@profile')->name('profile');

    // Filter
    Route::get('filter', 'FilterController@index')->name('filter-page');
    Route::get('to-verify', 'ToVerifyController@index')->name('to-verify-page');
    Route::get('to-verify/{id}', 'ToVerifyController@detail');

    Route::post('/to-verify/store', 'ToVerifyController@store');
    Route::post('/to-verify/approve', 'ToVerifyController@toApprove');

    Route::post('/avatar/store{id}', 'AvatarController@store');
    Route::post('/avatar/active', 'AvatarController@setactive');

    Route::post('/video/store{id}', 'VideoController@store');
    Route::delete('/video/destroy{id}', 'VideoController@destroy');
    Route::post('/video/active', 'VideoController@setactive');
    Route::get('/getimages{id}', 'AvatarController@getimages');
    Route::get('/getvideos{id}', 'VideoController@getvideos');
    Route::post('/avatar/destroy{id}', 'AvatarController@destroy');
});


Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
    // Home page

    Route::get('general-stats', 'HomeController@general_stats');
    Route::get('escort-trans', 'HomeController@escort_trans');
    Route::get('user-stats', 'HomeController@user_stats');
    Route::get('tariff', 'HomeController@tariff');
    Route::get('accounts', 'HomeController@accounts');
    Route::get('ads-table', 'HomeController@ads_table');
    Route::get('comparison', 'HomeController@comparison');

    // Profile

    Route::post('settings-update/{telephone}', 'ProfileController@update');
    Route::post('settings-change/{telephone}', 'ProfileController@change');
    Route::post('settings-continue/{telephone}', 'ProfileController@continu');
    Route::post('settings-delete/{telephone}', 'ProfileController@delete');
    Route::post('profile-save/{telephone}', 'ProfileController@save');

    // Filter
    Route::group(['prefix' => 'filter'], function (){
        Route::get('cities/{table}', 'FilterController@getCities');
        Route::get('table/{table}/{city}', 'FilterController@getTable');
    });
});
