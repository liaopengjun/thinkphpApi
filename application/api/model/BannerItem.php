<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-02
 * Time: 21:20
 */

namespace app\api\model;


use think\Model;

class BannerItem extends Model
{
    protected $hidden = ['id','img_id','banner_id','delete_time','update_time'];

    /**
     * Image 关联模型
     *  BannerItem 当前模型
     *  img_id 外键
     *  id 当前模型主键
     */
    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }
}