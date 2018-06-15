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

        Route::get('test',function (){
            return 'Your email is verified';
        });
    });
//    结束
});
