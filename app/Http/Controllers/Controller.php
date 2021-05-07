<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use JetBrains\PhpStorm\Pure;
use function array_merge;
use function mt_rand;
use function response;
use function str_shuffle;
use function strlen;
use function substr;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
     *  $code 0=>成功,1=>未登录,2=>服务器错误
     */
    protected function apiResponse( $data = null,$code = 0, $message = '',$status=200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
                'code'    => $code,
                'message' => $message==''?null:$message,
                'data' => $data
        ],$status);
    }

    protected function randomString($length=4): string
    {
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        return substr(str_shuffle($pattern),mt_rand(0,strlen($pattern)-11),$length);
    }
}
