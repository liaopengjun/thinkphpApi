<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-02
 * Time: 21:41
 */

namespace app\api\model;


class Image extends BaseModel
{
    protected $hidden = ['id','from','delete_time','update_time'];
    //获取url图片的路径
    public function getUrlAttr($value,$data)
    {
        return $this->preixUrlimg($value,$data);
    }
}