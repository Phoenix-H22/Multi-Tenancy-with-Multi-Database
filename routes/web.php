<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/users', function () {
    return [
        'tenant' => app('tenant'),
        'users' => \App\Models\User::all()
    ];
});


Route::get('/', function () {
    return view('welcome');
});



Route::get('/home', 'HomeController@index')->name('home');

