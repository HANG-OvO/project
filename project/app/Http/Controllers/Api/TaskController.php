<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/3/20
 * Time: 12:41 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    public function get_task_list()
    {

        $task = DB::select('select * from task where is_delete = ?',[0]);
        return $this->resposne(200,'ok',$task);
    }


    /**
     * 验证用户是否做过该任务
     */
    public function check_user_task(Request $request){

        $task_id = $request->get('task_id');
        if(!$task_id){
            return $this -> resposne(400,"任务ID为空");
        }

        $task = DB::table("task")->where("id",$task_id)->first();
        if(!$task){
            return $this -> resposne(400,"任务不存在");
        }

        $ip = $request->getClientIp();
        $user_id = 1;
        $user_task_log = DB::table("user_task_log")
            ->where("user_id",$user_id)
            ->where('ip',$ip)
            ->where("task_id",$task_id)
            ->first();

        if($user_task_log){
            return $this -> resposne(400,"您已经做个该任务 请检查你的ip");
        }

        $use_log_id = DB::table('user_task_log')->insertGetId([
            "user_id" =>$user_id,
            "task_id" =>$task_id,
            "ip"=>$ip
            ]);
        if(!$use_log_id){
            return $this -> resposne(400,"添加任务失败");
        }
        $str = $user_id."-".$task_id."-".$ip;
        $encrypted = Crypt::encryptString($str);
        return $this -> resposne(200,"成功",$encrypted);
    }
}