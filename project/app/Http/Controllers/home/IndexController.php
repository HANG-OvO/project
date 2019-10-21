<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    /**
    * 函数的含义说明
    *
    * @access public
    * @param mixed $arg1 参数一的说明
    * @param mixed $arg2 参数二的说明
    * @param mixed $mixed 这是一个混合类型
    * @return array 返回类型
    */
    public function index(){
        echo "前台首页";
    }
}
