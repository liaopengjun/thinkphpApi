<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-09
 * Time: 22:11
 */

namespace app\api\controller;
use think\Controller;
use app\api\service\Token as TokenService;


class BaseController extends Controller
{

    //验证收货地址访问接口权限层
    public function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }
    //验证订单访问接口权限层
    public function checkExclusiveScope(){
        TokenService::needPrimaryScope();
    }
    //验证支付访问接口权限层
    protected function checkSuperScope()
    {
        TokenService::needSuperScope();
    }


}