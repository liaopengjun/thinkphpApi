<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-03
 * Time: 14:45
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected  $rule = [
        'ids'=>'require|checkIds',
    ];


    protected  $message = [
        'ids' => 'ids必须是一个以,分隔的多个正整数',
    ];


    //验证ids
    protected function  checkIds($value){

        $value = explode(',',$value);

        if(empty($value)){
            return false;
        }

        foreach ($value as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}