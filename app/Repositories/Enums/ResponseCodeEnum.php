<?php
/**
 * @ClassName ResponseCodeEnum
 * @Descridtion //TODO $
 * @Author Fendy
 * @Date 2021/4/14 13:29
 * @Version 1.0
 **/


namespace App\Repositories\Enums;


class ResponseCodeEnum
{

    // 客户端错误码：400 ~ 499 开头，后拼接 3 位
    const CLIENT_PARAMETER_ERROR = 400001;  // 参数错误
    const CLIENT_CREATED_ERROR = 400002;    // 创造错误
    const CLIENT_DELETED_ERROR = 400003;    // 删除错误
}
