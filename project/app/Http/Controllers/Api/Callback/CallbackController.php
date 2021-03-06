<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/3/21
 * Time: 12:26 PM
 */

namespace App\Http\Controllers\Api\Callback;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{

    CONST STATE_COMPLETE = 'complete'; // 成功

    CONST STATE_SCREEN = 'screen'; // 甄别

    CONST STATE_QUOTA_FULL = 'quota_full'; // 配额满

    CONST STATE_SHORT_TIME = 'short_time'; // 作答时间短

    //注册
    public function taskback(Request $request){

        try {

            $params['task_id'] = $request->get('param1'); // 任务Id
            $params['user_token'] = $request->get('param2'); // 用户标识
            $params['state'] = $request->get('param3'); // 作答结果
            $params['time'] = $request->get('time'); // 时间戳
            $params['sign'] = $request->get('sign'); // 签名

            Log::debug("接口参数",$params);

            if (!$params['task_id'] || !$params['user_token']) {
                // 参数错误记录日志
                Log::debug("参数错误",$params);
                header('Location:http://lhorz.cn/#/tasks');die;
                return $this->resposne(200);
            }

            // 验证任务id
            $task = DB::table('task') -> where('task_id', $params['task_id']) -> get();
            if (!$task) {
                // 任务有误记录日志
                Log::debug("任务未找到",$params);
                header('Location:http://lhorz.cn/#/tasks');die;
                return $this->resposne(200);
            }
            // 验证用户
            $user_info = explode('-',$params['user_token']);
            $user_id = $user_info[0];
            $ip = $user_info[3];
            $user = DB::table('user') -> where('user_id', $user_id) -> get();
            if (!$user) {
                // 用户有误，记录日志
                Log::debug("用户未找到",[$params,$user_info]);
                header('Location:http://lhorz.cn/#/tasks');die;
                return $this->resposne(200);
            }
            // 修改任务状态
            $user_task_log = DB::table('user_task_log')
                ->where('user_id', $user_id)
                ->where('task_id', $params['task_id'])
                ->where('ip', $ip)
                ->get();
            if (!$user_task_log) {
                // 任务未查到记录日志
                Log::debug("任务记录未找到",[$params,$user_info]);
                header('Location:http://lhorz.cn/#/tasks');die;
                return $this->resposne(200);
            }
            $result = DB::update('update user_task_log set state = ? where user_id = ? and task_id = ? and ip = ?', [$params['state'],$user_id, $params['task_id'], $ip]);
            // 记录执行日志
            Log::debug("执行结果",[$result]);
            header('Location:http://lhorz.cn/#/tasks');die;
            return $this->resposne(200);

        } catch (\Exception $e) {

            Log::debug("执行结果",[$e->getMessage()]);
            header('Location:http://lhorz.cn/#/tasks');die;
            return $this->resposne(200);

        }

    }

}