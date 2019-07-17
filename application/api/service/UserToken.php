<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-05
 * Time: 10:02
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;
use think\Log;

class UserToken extends Token
{

    protected $code;
    protected $WxAppid;
    protected $WxAppSeret;
    protected $WxLogUrl;

    //初始化参数

    public function __construct($code)
    {
        $this->code = $code;
        $this->WxAppid = config('wx.app_id');
        $this->WxAppSeret = config('wx.app_secret');
        $this->WxLogUrl = sprintf(config('wx.login_url'),$this->WxAppid,$this->WxAppSeret,$this->code);
    }

    //获取用户信息

    public function get(){
        $result = curl_get($this->WxLogUrl);
        $wxResult = json_decode($result,true);
        if(empty($wxResult)){
            throw new Exception("获取session_key及Openid时异常，微信内部错误");
        }else{
            $loinFail = array_key_exists('errcode',$wxResult);
            if($loinFail){
                $this->processLoginErorr($wxResult);
            }else{
               return $this->grantToken($wxResult);
            }
        }
    }

    //正确返回处理，保存用户信息 openid
    private function grantToken($wxResult){

        //获取openid
        $openid = $wxResult['openid'];
        //是否存表过
        $user = UserModel::getByopenid($openid);

        if($user){
            $uid = $user['id'];
        }else{
            //插入用户
            $uid =  $this->newUser($openid);
        }

        //需要缓存数据
        $cachedVakue = $this->prepareCachedValue($wxResult,$uid);
        //生产令牌 写入缓存
        $token = $this->saveToCached($cachedVakue);

        //返回令牌
        return $token;
    }

    //设置缓存
        private function saveToCached($cachedVakue){
            //加密令牌
            $key = self::generateToken();
            $value = json_encode($cachedVakue);

            //过期时间
            $expire = config('setting.token_expire_in');

            Log::init([
                'type'  =>  'File',
                'path'  => LOG_PATH,
                'level' => ['success']
            ]);
            Log::record($key,'success');
            Log::record($value,'success');
            Log::record($expire,'success');
            //写入缓存
            $request = cache($key,$value,$expire);
            if(!$request){
                //抛出异常
                 throw new TokenException([
                     'msg' => '服务器缓存异常',
                     'errorCode' => 10005
                 ]);
            }
            return $key;
        }

    //构建需要缓存的值
    private function prepareCachedValue($wxResult,$uid){
            $cachedValue = $wxResult;
            $cachedValue['uid'] = $uid;
            //scope ==16  app用户 ||  scope ==32 管理用户
            $cachedValue['scope'] = 16;
            return $cachedValue;
     }

    //插入用户操作
    private function newUser($openid){
        $data = [
            'openid'=>$openid,
        ];
        $user = UserModel::create($data);
        return $user -> id;
    }



    //定义错误返回码
    protected function processLoginErorr($wxResult){
        throw new WeChatException([
                'msg' => $wxResult['errmsg'],
                'errorCode' => $wxResult['errcode'],
        ]);
    }
}