<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-05
 * Time: 11:38
 */

namespace app\lib\exception;


class WeChatException extends  BaseException
{
    public  $code =404;
    public  $msg = '';
    public  $errorCode = '999';
}