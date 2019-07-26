<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use app\api\model\UserAddress;

class Address extends BaseController
{

    //前置方法
    protected $beforeActionList = [
        "checkPrimaryScope" =>  ["only" => "createorupdateaddress"],
    ];

    //获取收货地址
    public static function getUserAddress(){
        $uid = TokenService::getCurrentUid();
        $userAddress = UserAddress::where('user_id', $uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
//        $userAddress['snap_items']=json_decode($userAddress['snap_items'],true);
        return json($userAddress);
    }

    public function createOrUpdateAddress(){
        $data = input('post.');
        //验证
        $validate = new AddressNew();
        $validate->goCheck();

        //根据Token获取用户uid
        //验证用户是否存在 否则抛出异常
        //构建地址信息参数
        //验证是否存在地址则更新，不存在则添加

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw  new UserException();
        }

        $dataArray = $validate->getDataByRule($data);
        $userAddress = $user->address;

        if(!$userAddress){
            //新增地址
            $user->address()->save($dataArray);
        }else{
            //地址
            $user->address->save($dataArray);
        }
        return json(new SuccessMessage(),201);
    }

}