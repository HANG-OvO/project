<?php

namespace App\Http\Controllers;

use http\Env\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

<<<<<<< HEAD

    public function resposne($status,$message,$content = []){
=======
    public function resposne($status,$message = "",$content = []){
>>>>>>> 770761f8b292add600d9d19783ce96e0f5f95f16
        return response() -> json([
            "status" => $status,
            "content" => $content,
            "message" => $message
        ]);
    }
}
