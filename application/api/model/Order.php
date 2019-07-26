<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-11
 * Time: 10:19
 */

namespace app\api\model;


class Order extends BaseModel
{

    protected $hidden = ['user_id','update_time'];
    protected $autoWriteTimestamp=true;

    //分页
    public  static function getSummaryByUser($uid,$page=1,$size=15){
            $paginate = self::where('user_id','=',$uid)
                ->order('create_time desc')
                ->paginate($size,true,['page'=>$page]);
            return $paginate;
    }
}