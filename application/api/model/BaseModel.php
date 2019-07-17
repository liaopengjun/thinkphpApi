<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-03
 * Time: 11:04
 */

namespace app\api\model;

use think\Model;

class BaseModel extends  Model
{
    //获取url图片的路径
    protected function preixUrlimg($value,$data){
        if($data['from'] == 1){
            return config('setting.img_prefiex').$value;
        }
        return $value;
    }

}