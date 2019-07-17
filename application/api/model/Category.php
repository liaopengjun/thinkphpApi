<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-04
 * Time: 15:41
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time','update_time'];

    public function Img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

}