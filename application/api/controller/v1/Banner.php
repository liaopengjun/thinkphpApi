<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-06-25
 * Time: 14:38
 */

namespace  app\api\controller\v1;
use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;

class Banner
{
    /**
     * @param $id banner信息
     */
        public function getBanner($id){
            //验证
            $validate = new IDMustBePostiveInt();
            $validate->goCheck();

            $Banner = BannerModel::getBannerByID($id);

            if(!$Banner){
                throw  new BannerMissException();
            }

//            $c = config('setting.img_prefiex');
            return json($Banner);

        }
}