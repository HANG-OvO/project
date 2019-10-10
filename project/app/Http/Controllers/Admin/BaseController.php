<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
* 基础控制器
*
* @author      李航
* @version     1.0 版本号
*/
class BaseController extends Controller
{

    /**
    * 后台公共布局
    *
    * @access public
    * @return string(后台公共布局视图)
    */
    public function layout(){
        return view("admin.layout.layout");
    }
}
