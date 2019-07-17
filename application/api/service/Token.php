<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-05
 * Time: 14:48
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use think\Cache;
use think\Request;
use think\Exception;
use app\lib\exception\TokenException;

class Token
{
    //加密令牌
    public static function generateToken(){
        //32位无意义字符串
        $randStr = getRandStr(32);
        //时间戳
        $timestamp = $_SERVER['REQUEST_TIME'];
        //salt 加密盐
        $salt = config('secure.token_salt');

        return md5($randStr.$timestamp.$salt);
    }

    //构建获取具体用户字段值方法
    public static function getCurrentTokenVar($key){
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        //判断是否缓存过
        if(!$vars){
            throw new TokenException();
        }else{
            //转数组
            if(!is_array($vars)){
                $vars = json_decode($vars,true);
            }
            //是否有uid
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                throw new Exception('尝试获取Token的key不存在');
            }

        }
    }


    //获取用户信息
    public static function getCurrentUid(){
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }


    //用户和cms管理员都有权限访问的接口权限
    public static function  needPrimaryScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope >= ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }

        }else{
            throw new TokenException();
        }
    }
    //只有用户才能访问
    public function needExclusiveScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope == ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }
    //只有管理员才能访问
    public static function needSuperScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::Super) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }
    /**
     * 检查操作UID是否合法
     * @param $checkedUID
     * @return bool
     * @throws Exception
     * @throws ParameterException
     */
    public static function isValidOperate($checkedUID)
    {
        if(!$checkedUID){
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if($currentOperateUID == $checkedUID){
            return true;
        }
        return false;
    }


}