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

class UserController extends Controller
{

    //注册
    public function register(Request $request){

        $user_name = $request->post('user_name');

        if( !$user_name ){
            return $this -> resposne(400,"用户名不能为空");
        }

        $password = $request -> post("password",null);
        if( !$password ){
            return $this -> resposne(400,"密码不能为空");
        }

        $phone = $request->post('phone');

        $user = DB::select('select * from user where user_name = ?',[$user_name]);

        if($user){
            return $this->resposne("400",'用户名已存在');
        }

        $user = DB::table('user')->insertGetId([
            'user_name' => $user_name,
            'password' => $password,
            'phone' => $phone,
        ]);

        return $this->resposne('200','注册成功');

    }


    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){

        $user_name = $request->post('user_name');

        if( !$user_name ){
            return $this -> resposne(400,"用户名不能为空");
        }

        $password = $request -> post("password",null);
        if( !$password ){
            return $this -> resposne(400,"密码不能为空");
        }

        $user = DB::select('select * from user where user_name = ? and password = ?',[$user_name,$password]);

        if(!$user){
            return $this->resposne("400",'用户名不存在  请先注册');
        }
        var_dump($user);die;

        return $this->resposne('200','注册成功');

    }

}