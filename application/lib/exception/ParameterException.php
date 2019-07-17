<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-06-30
 * Time: 11:07
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public  $msg = '参数错误';
    public $errorCode = 10000;
}