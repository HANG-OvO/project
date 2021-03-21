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
        $password = "123456";
        $phone = "13522154864";

        $user = DB::select('select * from user where user_name = ?',[$user_name]);

        if($user){
            return $this->resposne("400",'用户名已存在');
        }

        var_dump($request->post('user_name'));die;

    }

}