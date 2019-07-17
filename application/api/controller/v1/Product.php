<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-04
 * Time: 14:11
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ProductException;

class Product
{
    //最新商品数量
    public function  getRecent($count=15){
        (new Count())->goCheck();

        $result = ProductModel::GetMostRecent($count);
        if(!$result){
            throw new ProductException();
        }
        return json($result);
    }

    //栏目下商品信息
    public function  getAllInCategory($id){
        $result = ProductModel::getProductByCategoryID($id);
        if(!$result){
            throw new ProductException();
        }
        return json($result);
    }

    //产品详情
    public function getOne($id){
        (new IDMustBePostiveInt())->goCheck();
        $result = ProductModel::getProductDetail($id);
        return json($result);
    }
}