<?php

namespace app\api\controller\v1;
use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Order as OrderServive;
use app\api\service\Token as TokenService;
use app\api\validate\PagingParameter;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;

class Order extends BaseController
{
    //前置方法
    protected $beforeActionList = [
        "checkExclusiveScope" =>  ["only" => "placeorder"],
        "checkPrimaryScope" =>["only"=>"getdetail,getsummarybyorder"],
    ];

    //获取提交订单商品信息
    //检查库存量(是否充足）
    //构建订单数据，返回支付状态
    //调用支付接口
    //支付前库存检测
    //发起支付 //验证访问接口权限层
    //返回支付结果 (库存检测,成功进行库存删除）

    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();
        $order = new OrderServive();
        $result = $order->place($uid,$products);
        return json($result);

    }

    //订单信息
    public function getSummaryByOrder($page,$size=15){
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $PageOrder = OrderModel::getSummaryByUser($uid,$page,$size);
        if($PageOrder->isEmpty()){
            return json([
                'data'=>[],
                'current_page'=> $PageOrder->currentPage(),
            ]);
        }else{
            $data = $PageOrder->hidden(['snap_items', 'snap_address'])
                ->toArray();
            return json([
                'data'=>$data,
                'current_page'=> $PageOrder->currentPage(),
            ]);

        }

    }
    //订单详情
    public function getDetail($id){
        (new IDMustBePostiveInt())->goCheck();
        $OrderDetail = OrderModel::get($id);
        if(!$OrderDetail){
            throw new OrderException();
        }
        return json($OrderDetail->hidden(['prepay_id']));
    }


}