<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-06
 * Time: 15:39
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}