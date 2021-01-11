<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {
    Route::group(['namespace' => 'General'], function () {
        Route::get('setting', 'GeneralController@settings');
        Route::get('contact', 'GeneralController@contactUs');
        Route::post('create_contact', 'GeneralController@createContactUs');
        Route::get('category', 'GeneralController@Categories');
        Route::get('city', 'GeneralController@cities');
        Route::post('block', 'GeneralController@blocks');
        Route::post('restaurant', 'GeneralController@restaurants');
        Route::get('get_reviews', 'GeneralController@getReviews');
        Route::get('payment_methods', 'GeneralController@paymentMethod');
        Route::get('notification', 'GeneralController@notifications');
        Route::get('orders', 'GeneralController@orders');
    });
    Route::post('restaurant_register', 'RestaurantAuthController@register');
    Route::post('restaurant_login', 'RestaurantAuthController@login');
    Route::post('client_register', 'ClientAuthController@register');
    Route::post('client_login', 'ClientAuthController@login');
    Route::post('restaurant_reset_password', 'RestaurantAuthController@resetPassword');
    Route::post('restaurant_new_password', 'RestaurantAuthController@newPassword');
    Route::post('client_reset_password', 'ClientAuthController@resetPassword');
    Route::post('client_new_password', 'ClientAuthController@newPassword');

    Route::group(['middleware' => 'auth:restaurant'], function () {
        Route::get('items', 'RestaurantMainController@items');
        Route::post('create_items', 'RestaurantMainController@createItems');
        Route::post('edit_items', 'RestaurantMainController@editItems');
        Route::post('delete_items', 'RestaurantMainController@deleteItems');
        Route::post('offers', 'RestaurantMainController@offers');
        Route::post('update_offers', 'RestaurantMainController@upDateOffers');
        Route::post('delete_offers', 'RestaurantMainController@deleteOffers');
        Route::post('restaurant_profile', 'RestaurantMainController@profileEdit');
        Route::get('restaurant_review', 'RestaurantMainController@restaurantReview');
        Route::post('restaurant_register_token', 'RestaurantMainController@RestaurantRegisterToken');
        Route::post('restaurant_remove_token', 'RestaurantMainController@RestaurantRemoveToken');
        Route::get('restaurant_orders', 'RestaurantMainController@orderDetails');
        Route::post('commission', 'RestaurantMainController@commission');
        Route::post('restaurant_new_order', 'RestaurantMainController@restaurantNewOrder');
        Route::post('restaurant_current_order', 'RestaurantMainController@restaurantCurrentOrder');
        Route::post('restaurant_old_order', 'RestaurantMainController@restaurantOldOrder');
        Route::post('restaurant_accept_order', 'RestaurantMainController@acceptedOrder');
        Route::post('restaurant_reject_order', 'RestaurantMainController@rejectedOrder');
        Route::post('restaurant_deliver_order', 'RestaurantMainController@deliveredOrder');

    });
    Route::group(['middleware' => 'auth:client'], function () {
        Route::post('review', 'ClientMainController@review');
        Route::post('profile_edit', 'ClientMainController@profileEdit');
        Route::post('client_profile', 'ClientMainController@profileEdit');
        Route::get('show_offers', 'ClientMainController@showOffers');
        Route::post('show_items', 'ClientMainController@showItems');
        Route::get('open_restaurants', 'ClientMainController@getOpenRestaurant');
        Route::get('client_review', 'ClientMainController@clientReview');
        Route::post('restaurant_reviews', 'ClientMainController@restaurantReviews');
        Route::post('client_register_token', 'ClientMainController@ClientRegisterToken');
        Route::post('client_remove_token', 'ClientMainController@ClientRemoveToken');
        Route::post('new_order', 'ClientMainController@newOrder');
        Route::get('client_orders', 'ClientMainController@orderDetails');
        Route::get('client_current_order', 'ClientMainController@clientCurrentOrder');
        Route::post('show_order', 'ClientMainController@showOrder');
        Route::get('client_old_order', 'ClientMainController@clientOldOrder');
        Route::post('delivered_order', 'ClientMainController@deliveredOrder');
        Route::post('declined_order', 'ClientMainController@declinedOrder');
    });
});
