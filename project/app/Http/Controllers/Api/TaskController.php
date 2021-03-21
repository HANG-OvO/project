<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/3/20
 * Time: 12:41 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    public function get_task_list()
    {

        $task = DB::select('select * from task where is_delete = ?',[0]);
        return $this->resposne('200','ok',$task);
    }
}