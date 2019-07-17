<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-10
 * Time: 16:03
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public  $msg = '订单不存在 请检查ID';
    public $errorCode = 70000;

}