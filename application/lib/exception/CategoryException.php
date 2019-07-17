<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-04
 * Time: 16:15
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    protected  $code =  404;
    protected  $msg = '指定商品栏目不存在,请检查栏目ID';
    protected  $errorCode = '50000';
}