<?php
namespace app\index\controller;


use think\cache\driver\Redis;
use think\Exception;

class Index
{
    /**
     *
     */

    public function index()
    {
        //事务
//        try {
//            $redis = new Redis();
//            //启动事务
//            $redis->multi();
//            $redis->hset('user1','name','dengyiqin');
//            $redis->hset('user1','age','21');
//            $redis->hset('user1','sex','女');
//            return false;
//            //执行事务
//           $redis->exec();
//        }catch (Exception $e){
//            //取消事务
//            $redis->discard();
//            throw $e;
//        }


//        哈希
//        $redis->hset('user1','name','dengyiqin');
//        $redis->hset('user1','age','21');
//        $redis->hset('user1','sex','女');
//
//        $user1 = $redis->hget('user1');
//      $user1 = $redis->get('user1');
//        dump($user1);die;
//          $userstatus = $redis->hdel('user1',['age','sex']);

//        $len = $redis->hlen('user1');

//        $str = "1:苹果
//        2:栗子
//        3:桃子
//        4:荔枝
//        5:红提";
//        $res = $this->parse_field_attr($str);
//        $code  =rand(000000,999999);
//        dump($code);
        $res = $this->get_number(1000201);
        dump($res);die;

    }

    function parse_field_attr($string) {
        if(0 === strpos($string,':')){
            // 采用函数定义
            return   eval('return '.substr($string,1).';');
        }elseif(0 === strpos($string,'[')){
            // 支持读取配置参数（必须是数组类型）
            return C(substr($string,1,-1));
        }

        $array = preg_split('/\n+/', $string);
        dump($array);die;
        if(strpos($string,':')){
            $value  =   array();
            foreach ($array as $val) {
                list($k, $v) = explode(':', $val);
                $value[$k]   = $v;
            }
        }else{
            $value  =   $array;
        }
        return $value;
    }
    /**
     * 数值转换
     */
    function get_number($sum){

        if ($sum >= 100000000) {
            return $sum / 100000000 .'亿';
        }else{
            if ($sum >= 10000) {
                return $sum / 10000 ."万";
            } else {
                return $sum;
            }
        }
    }



}
