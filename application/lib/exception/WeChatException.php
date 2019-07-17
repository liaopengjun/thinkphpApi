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
    protected  $code =  404;
    protected  $msg = '';
    protected  $errorCode = '999';
}