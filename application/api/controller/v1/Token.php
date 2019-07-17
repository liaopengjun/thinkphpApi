<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-05
 * Time: 09:21
 */

namespace app\api\controller\v1;
use app\api\service\UserToken;
use app\api\validate\TokenGet;


class Token
{


    public function  getToken($code = ''){
            (new TokenGet())->goCheck();
            $ut = new UserToken($code);
            $token['token'] = $ut->get($code);
            $jsonToken = json_encode($token);
            return $jsonToken;

        }

}