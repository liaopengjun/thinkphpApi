<?php
namespace app\index\controller;


use think\cache\driver\Redis;

class Index
{
    /**
     *
     */

    public function index()
    {
//
        $str = '[{"id":5,"haveStock":true,"counts":1,"price":"0.01","name":"\u6625\u751f\u9f99\u773c 500\u514b","totalPrice":0.01000000000000000020816681711721685132943093776702880859375,"main_img_url":"http:\/\/zerg.demo.com\/images\/product-dryfruit@2.png"}]';
        $arr = json_decode($str,true);
        dump($arr);die;
    }
}
