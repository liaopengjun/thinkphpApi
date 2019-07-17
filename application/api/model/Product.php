<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-03
 * Time: 14:06
 */

namespace app\api\model;


use app\lib\exception\ProductException;

class Product extends BaseModel
{
    protected $hidden = ['create_time','update_time','from','pivot','category_id','delete_time'];
    //拼接url路径
    public function getMainImgUrlattr($value,$data){
        return $this->preixUrlimg($value,$data);
    }

    //获取指定数量最新商品
    public static function  GetMostRecent($count){
        $productList = self::limit($count)->order('create_time  desc')->select();
        return $productList;
    }

    //获取指定栏目下商品
    public static function getProductByCategoryID($id){
        $product = self::where('category_id',$id)->select();
        if(!$product){
            throw new ProductException();
        }
        return $product;
    }
    //一对多关联  商品图片
    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }
    //一对多关联 商品属性
    public function properties(){
        return $this->hasMany('productProperty','product_id','id');
    }
    //商品详情
    public static function getProductDetail($id){
        $producrt = self::with([
            'imgs' => function ($query){
                $query->with(['imgUrl'])->order('order asc');
             }
             ])
            ->with(['properties'])
            ->find($id);
        return $producrt;

    }

}