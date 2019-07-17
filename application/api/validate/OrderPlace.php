<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-10
 * Time: 10:26
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{

    protected  $rule = [
        'products' =>'checkProducts'
    ];

    protected $singleRule = [
        'product_id'=>'require|isPositiveInteger',
        'count'=>'require|isPositiveInteger',
    ];

    protected function  checkProducts($value){
        if(!is_array($value)){
            throw new ParameterException([
                'msg'=> ' 商品参数不正确',
            ]);
        }

        if(empty($value)){
            throw new ParameterException([
                'msg'=> '商品列表不能为空',
            ]);
        }

        foreach ($value as $value1){
            $this->checkproduct($value1);
        }
        return true;
    }

    protected function checkproduct($value){

        $validata = new BaseValidate($this->singleRule);
        $result = $validata->check($value);

        if(!$result){
            throw new ParameterException([
                'msg'=> '商品列表参数错误',
            ]);
        }

    }
}