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


/*
 * 前台路由
 */
Route::namespace("Home") -> group(function () {
    Route::get('/',"IndexController@index");
});


/*
 * 后台路由
 */
Route::namespace('Admin') -> group(function () {

    /*
     * 后台登录
     */
    Route::get("/admin/login","LoginController@login");
    Route::post("/admin/doLogin","LoginController@doLogin");
    Route::post("/admin/quit","LoginController@quit");

    /*
     * 中间件组
     */
    Route::middleware("control") -> group(function () {
        /*
         * 公共布局
         */
        Route::get("/admin","BaseController@layout");
        /*
         * 首页
         */
        Route::get("/admin/index","IndexController@index");
    });
});