<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-09
 * Time: 10:24
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 402;
    public  $msg = '权限不够';
    public $errorCode = 10001;
}