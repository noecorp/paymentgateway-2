<?php

use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("test",function(){
	return response()->json(["name"=>"jackson","age"=>"9"]);
});

Route::post('customer/pay',['as'=>'customer.pay','uses'=>'CustomerApiController@customerPay'])->middleware('auth_client');

// this interface to be put on the zatana site for clients to register for free and will be email passwords or tokens

Route::post('client/register',['as'=>'client.register','uses'=>'ClientApiController@clientRegister']);


Route::get('loading',['as'=>'redirect.loading','uses'=>'ClientRedirectPaymentCotroller@redirectLoading']);
Route::post('checkoutform',['as'=>'redirect.checkoutform','uses'=>'ClientRedirectPaymentCotroller@redirectCheckoutform']);
Route::post('checkoutform_user_details',['as'=>'redirect.checkoutform_user_details','uses'=>'ClientRedirectPaymentCotroller@redirectCheckoutformUserDetails']);

Route::post('checkoutform_verifyOTP',['as'=>'redirect.checkoutform_verifyOTP','uses'=>'ClientRedirectPaymentCotroller@redirectCheckoutformVerifyOTP']);
Route::post('checkoutform_password',['as'=>'redirect.checkoutform_password','uses'=>'ClientRedirectPaymentCotroller@redirectCheckoutformPassword']);

Route::get('checkout/{id}',['as'=>'view.checkout','uses'=>'ClientRedirectPaymentCotroller@viewCheckout']);

Route::get('checkout_verifyOTP/{id}/{cid}/{erid}',['as'=>'view.checkout_verifyOTP','uses'=>'ClientRedirectPaymentCotroller@viewCheckoutVerifyOTP']);

Route::get('checkout_password/{id}',['as'=>'view.checkout_password','uses'=>'ClientRedirectPaymentCotroller@viewCheckoutPassword']);
