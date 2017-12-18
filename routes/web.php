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
Route::get('/sample',['as'=>'sample','uses'=>'CustomerApiController@sample']);
Route::post('/sample/testxml',['as'=>'testxml','uses'=>'CustomerApiController@xmlTestReceive']);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/store/phone', 'HomeController@storePhone')->name('store.phone');
Route::get('/get/phones', 'HomeController@getPhones')->name('get.phones');
Route::delete('/delete/phone', 'HomeController@deletePhone')->name('delete.phone');
Route::get('/get/transactions', 'HomeController@getTransactions')->name('get.transactions');
// new routes
Route::post('/update/accountusage', 'HomeController@changeAccountUsage')->name('update.accountusage');
Route::get('/get/accountusage', 'HomeController@getAccountUsage')->name('get.accountusage');
Route::post('/update/custompriority', 'HomeController@updateCustomAccountPriority')->name('update.custompriority');
Route::get('/get/custompriority', 'HomeController@getCustomAccountPriority')->name('get.custompriority');
Route::post('/update/clientpriority', 'HomeController@updateClientAccountPriority')->name('update.clientpriority');
Route::get('/get/clientpriority', 'HomeController@getClientAccountPriority')->name('get.clientpriority');
Route::get('/get/credittransactions', 'HomeController@getUserCreditTransactions')->name('get.crdittransactions');
Route::get('/get/debittransactions', 'HomeController@getUserDebitTransactions')->name('get.debittransactions');
Route::get('/get/userclients', 'HomeController@getUserClients')->name('get.userclients');
Route::get('/get/usermobileaccounts', 'HomeController@getUserMobileAccounts')->name('get.usermobileaccounts');
Route::get('/get/userbankaccounts', 'HomeController@getUserBankAccounts')->name('get.userbankaccounts');
Route::get('/get/usercustomers', 'HomeController@getUserCustomers')->name('get.usercustomers');

Route::post('/get/usercredittransaction', 'HomeController@userCreditTransactionById')->name('update.usercredittransactionbyid');
Route::post('/update/transactionshowspan', 'HomeController@updateTransactionShowSpan')->name('update.transactionshowspan');
Route::get('/get/gettransactionsshowspan', 'HomeController@getTransactionsShowSpan')->name('get.gettransactionsshowspan');

Route::post('/update/phonenumber', 'HomeController@updatePhone')->name('update.phonenumber');


Route::get('/sendsms', 'HomeController@sendSMS')->name('sendsms');

