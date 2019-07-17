<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-05
 * Time: 09:24
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule =[
        'code' => 'require|isNotEmpty',
    ];

    protected  $message= [
        'code' =>'没有code无法获取Token',
    ];
}