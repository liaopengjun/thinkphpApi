<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-03
 * Time: 14:03
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as  ThemeModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    /**
     * @url /Theme?ids=1,2,3....
     */
    public  function  getSimpleList($ids=''){
        //验证 ids是否合法参数
        (new IDCollection())->goCheck();

        $ids = explode(',',$ids);
        $result = ThemeModel::with(['topicImg','headImg'])->select($ids);

        //异常处理
        if(!$result){
            throw new ThemeException();
        }
        return json($result);
    }

    /**
     * @url /Theme/1
     */
    public  function  getComplexOne($id){
        (new IDMustBePostiveInt())->goCheck();
        $result = ThemeModel::GetThemeWithProducts($id);
        //异常处理
        if(!$result){
            throw new ThemeException();
        }
        return json($result);



    }
}