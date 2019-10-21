<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-06-27
 * Time: 20:59
 */
namespace app\api\model;
use think\Model;

class Banner extends Model
{
    protected $hidden = ['delete_time','update_time'];

    /** BannerItem 关联模型
     *  banner_id BannerItem 外键
     *  id 当前模型主键
     */

    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }

    public static function getBannerByID($id){
        $Banner = self::with(['items','items.img'])->find($id);
        return $Banner;
    }
}