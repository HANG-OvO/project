<?php

use Illuminate\Http\Request;

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

Route::post('task_list', 'TaskController@get_task_list');
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

/*
 * 回调路由
 */
Route::namespace('Callback') -> group(function () {

    /*
     * 后台登录
     */
    Route::get("/callback/taskback","CallbackController@taskback");

});