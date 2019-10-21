<?php

namespace App\Http\Controllers\Admin;

/**
* 首页控制器
*
* @author      李航
* @version     1.0 版本号
*/
class IndexController extends BaseController
{

    /**
    * 后台首页
    *
    * @access public
    * @return string(后台首页视图)
    */
    public function index(){
        return view("Admin.index.index");
    }

}
