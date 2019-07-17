<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-04
 * Time: 15:00
 */

namespace app\lib\exception;

class ProductException extends BaseException
{
    protected  $code =  404;
    protected  $msg = '指定商品不存在,请检查商品ID';
    protected  $errorCode = '40000';
}