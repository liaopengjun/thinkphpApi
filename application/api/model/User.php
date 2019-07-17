<?php

namespace app\api\model;

use think\Model;

class User extends BaseModel
{


    /**
     * 用户是否存在
     * 存在返回uid，不存在返回0
     */
    public static function getByopenid($openid)
    {
        $user = User::where('openid', '=', $openid)
            ->find();
        return $user;
    }

    //一对一关联 收货地址
    public  function address(){

        return $this->hasOne('UserAddress','user_id','id');
    }
}
