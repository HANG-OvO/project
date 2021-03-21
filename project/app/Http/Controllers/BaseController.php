<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/3/21
 * Time: 2:30 PM
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class BaseController
{
    protected $user_id;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $token = \Request::header('token');
        //解密
        return $this->decrypt($token);
    }


    public function resposne($status,$message,$content = []){
        return response() -> json([
            "status" => $status,
            "content" => $content,
            "message" => $message
        ]);
    }


    public function decrypt($token){
        try {
            $str = Crypt::decryptString($token);
            $data = explode("-",$str);
            $this->user_id = $data[0];
        } catch (DecryptException $e) {
            //返回异常
            echo json_encode(['status'=>100,'message'=>'authentication failed']);
            exit();
            //return $this->resposne('100','authentication failed');
        }

    }

}