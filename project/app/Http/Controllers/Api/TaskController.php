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

class TaskController extends BaseController
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

        $task = DB::table("task")
            ->where("id",$task_id)
            ->where("is_delete",0)
            ->first();
        if(!$task){
            return $this -> resposne(400,"任务不存在");
        }

        $ip = $request->getClientIp();
        $user_id =  $this->user_id;
        $user_task_log = DB::table("user_task_log")
            ->where("user_id",$user_id)
            ->where('ip',$ip)
            ->where("task_id",$task_id)
            ->first();

        if(isset($user_task_log->state)){
            return $this -> resposne(400,"您已经做个该任务 请检查你的ip");
        }

        if(!$user_task_log){

            $str = $user_id."-".$task_id."-".$ip;
            $encrypted = Crypt::encryptString($str);

            $use_log_id = DB::table('user_task_log')->insertGetId([
                "user_id" =>$user_id,
                "task_id" =>$task_id,
                "ip"=>$ip,
                "user_sign"=>$encrypted
            ]);
            if(!$use_log_id){
                return $this -> resposne(400,"添加任务失败");
            }

        }else{
            $encrypted = $user_task_log->user_sign;
        }


        return $this -> resposne(200,"成功",$encrypted);
    }


    /**
     * 添加任务
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_task(Request $request){

        $task_id = $request->get('task_id');

        $task_url = $request->get('task_url');

        if(!$task_url){
            return $this -> resposne(400,"任务链接不能为空");
        }

        $task_title = $request->get('task_title');

        if(!$task_title){
            return $this -> resposne(400,"任务标题不能为空");
        }


        $task = DB::table("task")->where("task_url",$task_url)->first();
        if($task) {
            return $this->resposne(400, "你已添加过该任务 请确认在添加");
        }

        $task= DB::table('task')->insertGetId([
            "task_id" =>$task_id,
            "task_url" =>$task_url,
            "task_title"=>$task_title
        ]);

        if(!$task){
            return $this -> resposne(400,"添加失败");
        }
        return $this -> resposne(200,"成功");
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del_task(Request $request){

        $task_id = $request->get('task_id');

        $task = DB::table("task")->where("id",$task_id)->first();
        if(!$task) {
            return $this->resposne(400, "您删除的任务不存在");
        }

        $result = DB::update('update task set is_delete = ? where id = ? ', [1,$task_id]);
        if(!$result){
            return $this -> resposne(400,"删除失败");
        }
        return $this -> resposne(200,"删除成功");
    }
}