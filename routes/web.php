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
    return redirect('root');
});

Route::get('root','PagesController@root')->name('root');
Auth::routes();
Route::group(['middleware'=>'auth'],function (){
//    邮箱激活
    Route::get('email_verification/verify','EmailVerificationController@verify')->name('email_verification.verify');
//   邮箱手动激活
    Route::get('email_verification/send', 'EmailVerificationController@send')->name('email_verification.send');


    Route::get('email_verifiy_notic','PagesController@emailVerifyNotice')->name('email_verifiy_notic');
//    开始验证邮箱是否激活
    Route::group(['middleware'=>'email_verified'],function (){
        Route::get('user_addresses','UserAddressesController@index')->name('user_addresses.index');
        Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
        Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
//        编辑
        Route::get('user_addresses/{address}','UserAddressesController@edit')->name('user_addresses.edit');
//        更新
        Route::put('user_addressses/{address}','UserAddressesController@update')->name('user_addresses.update');
//        删除
        Route::delete('user_addresses/{address}','UserAddressesController@destroy')->name('user_addresses.destroy');


    });
//    结束
});
