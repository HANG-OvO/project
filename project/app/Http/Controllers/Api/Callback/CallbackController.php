<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/3/21
 * Time: 12:26 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CallbackController extends Controller
{

    //注册
    public function taskback(Request $request){

        var_dump($request);die;

        $params['task_id'] = $request->get('param1'); // 任务Id
        $params['user_token'] = $request->get('param2'); // 用户标识
        $params['state'] = $request->get('param3'); // 作答结果
        $params['time'] = $request->get('time'); // 时间戳
        $params['sign'] = $request->get('sign'); // 签名

        var_dump($params);

    }

}