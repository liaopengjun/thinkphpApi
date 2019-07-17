<?php
/**
 * Created by PhpStorm.
 * User: liaopengjun
 * Date: 2019-07-04
 * Time: 15:36
 */

namespace app\api\controller\v1;
use  app\api\model\Category as CategoryModel;

class Category
{

  public function  getAllCategories(){
        $categoies = CategoryModel::all([],'img');
        if(!$categoies){
            throw new CategoryException();
        }
        return json($categoies);
  }

}