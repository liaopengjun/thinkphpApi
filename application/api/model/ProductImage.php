<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-06
 * Time: 10:56
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id','product_id','delete_time'];

    //一对一关联  获取image图片
    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');
    }

}