<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-03
 * Time: 14:05
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['delete_time','update_time','topic_img_id','head_img_id'];

    /** 首页专题 img
     *
    */

    public function topicImg(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    /**
     *  专题内页 img
     */

    public  function  headImg(){
        return $this->belongsTo('Image','head_img_id','id');
    }

    /**
     *  专题下的产品 多对多的关系
     *  Product 关联模型
     *  Theme_product 中间表
     *  theme_id  product_id 外键
     */
    public  function  products(){
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    /**
     *
     */

    public static function  GetThemeWithProducts($id){
        $themes = self::with('products,topicImg,headImg')->find($id);
        return $themes;

    }
}