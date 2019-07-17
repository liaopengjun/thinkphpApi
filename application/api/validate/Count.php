<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-04
 * Time: 14:25
 */

namespace app\api\validate;


class Count extends  BaseValidate
{
    protected  $rule=[
      'count'=>'isPositiveInteger|between:1,15',
    ];

}