<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-06-27
 * Time: 21:51
 */
namespace app\lib\exception;
class BannerMissException extends BaseException
{
    public $code = 400;
    public  $msg = '请求的banner不存在';
    public $errorCode = 40000;
}