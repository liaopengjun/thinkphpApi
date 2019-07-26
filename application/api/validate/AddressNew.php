<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-06
 * Time: 14:31
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
        protected  $rule = [
            'name' => 'require|isNotEmpty',
            'mobile' => 'require',
            'province' => 'require|isNotEmpty',
            'city' => 'require|isNotEmpty',
            'country' =>'require|isNotEmpty',
            'detail' =>'require|isNotEmpty',
        ];


}