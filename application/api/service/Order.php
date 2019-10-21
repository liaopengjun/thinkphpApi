<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-10
 * Time: 11:46
 */

namespace app\api\service;
use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\UserException;
use think\Exception;
use think\Db;

class Order
{
    //传递过来的订单参数
    protected $oproducts;
    //真实的商品信息
    protected $products;
    //用户
    protected $uid;

    //构建下单接口
    public function place($uid,$oproducts){

        $this->oproducts = $oproducts;
        $this->products = $this->getProductsByOrder($oproducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        //检测库存
        if(!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }
        //创建订单操作
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;

     }
     //创建订单表
     protected function createOrder($sanp){
        try {

            $orderNo = $this->makeOrderNo();//订单号
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $sanp['orderPrice'];
            $order->total_count = $sanp['totalCount'];
            $order->snap_img = $sanp['sanpImg'];
            $order->snap_name = $sanp['sanpName'];
            $order->snap_address = $sanp['sanpAddress'];
            $order->snap_items = json_encode($sanp['pStatus']);
            $order->save();

            //关联表
            $orderID = $order->id;
            $create_time = $order->create_time;
            foreach ($this->oproducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oproducts);

            return [
                'order_no'=>$orderNo,
                'order_id'=>$orderID,
                'create_time'=>$create_time,
            ];
        }catch (Exception $e){
           throw  $e;
        }

     }

    //生成订单快照
     protected function snapOrder($status){

        $sanp = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'sanpAddress' => null,
            'sanpName' => '',
            'sanpImg' => '',
        ];

         $sanp['orderPrice'] = $status['orderPrice'];//订单金额
         $sanp['totalCount'] = $status['totalCount'];//总数量
         $sanp['pStatus'] = $status['pStatusArray'];//历史订单
         $sanp['sanpAddress']= json_encode($this->getUserAddress());//订单收货地址
         $sanp['sanpName'] = $this->products[0]['name'];
         $sanp['sanpImg'] = $this->products[0]['main_img_url'];

         if( count($this->products) >1 ){
             $sanp['sanpName'] .= "等";
         }
        return $sanp;

     }
    protected function getUserAddress(){
        $userAddress = UserAddress::where('user_id', '=', $this->uid)
            ->find();
        if (!$userAddress) {
            throw new UserException(
                [
                    'msg' => '用户收货地址不存在，下单失败',
                    'errorCode' => 60001,
                ]);
        }
        return $userAddress->toArray();
    }
     //通过订单信息查询真实商品
    protected function getProductsByOrder($oproducts){
            $oPIDs = [];

            foreach ($oproducts as $item){
                array_push($oPIDs,$item['product_id']);
            }

            //获取所以传递的商品信息
            $produts = Product::all($oPIDs)->visible(['id', 'price', 'stock', 'name', 'main_img_url'])->toArray();
            return $produts;

    }

    //对比商品(订单状态）
    private function getOrderStatus(){
        $status = [
            'pass'=>true,//订单状态
            'orderPrice'=>0,//订单的总价格
            'totalCount'=>0,
            'pStatusArray'=>[],//历史订单
        ];
        foreach ($this->oproducts as $oproduct){
            $Pstatus = $this->getProductStatus($oproduct['product_id'],$oproduct['count'],$this->products);

            if(!$Pstatus['haveStock']){
                $status['pass']=false;
            }

            //订单所有的商品总金额
            $status['orderPrice'] += $Pstatus['totalPrice'];
            $status['totalCount'] += $Pstatus['counts'];

            //历史订单
            array_push($status['pStatusArray'],$Pstatus);

            return $status;

        }

    }
    private function getProductStatus($oPID,$ocount,$products){
            $pIndex = -1;//商品是否下架
            $pStatus = [
                'id'=>null,
                'haveStock'=>false,//库存
                'counts'=>0,
                'price'=>0,
                'name'=>'',//商品名称
                'totalPrice'=>0,//订单内某一类商品和数量相乘的价格
                'main_img_url'=>null,
            ];

            for ($i=0;$i<count($products);$i++){
                if($oPID==$products[$i]['id']){
                    $pIndex = $i;
                }
            }

            //验证是否商品下架
            if($pIndex == -1){
                throw new OrderException([
                    'msg'=>'id为'.$oPID.'商品不存在 创建订单失败',
                ]);
            }else{
                //
                $product = $products[$pIndex];
                $pStatus['id']=$product['id'];
                $pStatus['name']=$product['name'];
                $pStatus['counts']=$ocount;
                $pStatus['price']=$product['price'];
                $pStatus['totalPrice']=$product['price'] * $ocount;
                $pStatus['main_img_url']=$product['main_img_url'];

                if($product['stock'] = $ocount >= 0){
                    $pStatus['haveStock']=true;
                }
                return $pStatus;

            }

    }
    //订单号
    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }
    /**
     * @param string $orderNo 订单号
     * @return array 订单商品状态
     * @throws Exception
     */
    public function checkOrderStock($orderID)
    {

        // 一定要从订单商品表中直接查询
        // 不能从商品表中查询订单商品
        // 这将导致被删除的商品无法查询出订单商品来
        $oProducts = OrderProduct::where('order_id', '=', $orderID)
            ->select();
        $this->products = $this->getProductsByOrder($oProducts);
        $this->oproducts = $oProducts;
        $status = $this->getOrderStatus();
        return $status;
    }
}