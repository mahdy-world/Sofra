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

//Route::get('/', function () {
//    return view('welcome');
//});

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::Resource('blocks','BlockController');
Route::Resource('cities','CityController');
Route::Resource('clients','ClientController');
Route::Resource('restaurants','RestaurantController');
Route::Resource('categories','CategoryController');
Route::Resource('contact','ContactController');
Route::Resource('offers','OfferController');
Route::Resource('orders','OrderController');
Route::Resource('settings','SettingController');
Route::Resource('payments','PaymentMethodController');
Route::Resource('users','UserController');
Route::Resource('pays','PaymentController');
Route::Resource('roles','RoleController');
Route::get('get-change-password','UserController@getChangePassword');
Route::post('change-password','UserController@changePassword')->name('changePassword');
Route::get('active/{id}' , 'RestaurantController@active');
Route::get('disactive/{id}' , 'RestaurantController@disactive');
