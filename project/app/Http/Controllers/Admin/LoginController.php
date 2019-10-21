<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
* 登录控制器
*
* @author      李航
* @version     1.0 版本号
*/
class LoginController extends Controller
{

    /**
    * 后台登录
    *
    * @access public
    * @return string(后台登录页面视图)
    */
    public function login(Request $request)
    {
        $loginStatus = $this -> checkLoginStatus($request);
        if( $loginStatus ){
            return redirect("/Admin");
        }else{
            return view("Admin.login.login");
        }

    }

    /**
    * 后台登录
    *
    * @access public
    * @return json(登录状态)
    */
    public function doLogin(Request $request)
    {
        $username = $request -> post("username",null);
        if( !$username ){
            return $this -> resposne(400,"用户名不能为空");
        }
        $password = $request -> post("password",null);
        if( !$password ){
            return $this -> resposne(400,"密码不能为空");
        }
        $request -> session() -> put("userInfo","userInfo");
        return $this -> resposne(200,"登录成功");
    }

    /**
    * 检测登录状态
    *
    * @access public
    * @param mixed $request 请求信息
    * @return boolean
    */
    public function checkLoginStatus(Request $request){
        $userInfo = $request -> session() -> get("userInfo");
        if( $userInfo ){
            return true;
        }
        return false;
    }

    /**
    * 退出登录
    *
    * @access public
    * @param mixed $request 参数一的说明
    * @return array 返回类型
    */
    public function quit(Request $request){
        $request -> session() -> forget("userInfo");
        if ($request->session()->has('userInfo')) {
            return $this -> resposne(400,"退出登录失败");
        }else{
            return $this -> resposne(200,"退出登录成功");
        }
    }

}
