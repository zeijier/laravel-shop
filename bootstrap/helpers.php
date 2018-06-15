<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-06-15/0015
 * Time: 14:44
 */
function test_helper(){
    return 'OK';
}
function route_class(){
    return str_replace('.','-',Route::currentRouteName());
}