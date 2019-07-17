<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-03
 * Time: 15:57
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    protected  $code =  404;
    protected  $msg = '指定主题不存在,请检查主题ID';
    protected  $errorCode = '30000';
}