<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-08
 * Time: 17:15
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id','delete_time','user_id'];
}