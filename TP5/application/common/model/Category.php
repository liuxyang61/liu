<?php

namespace app\common\model;

use houdunwang\arr\Arr;
use think\Model;

class Category extends Model
{
    //
    protected $table = 'category';


    /**
     *将栏目数据处理为树状结构
     */
    public function getAllCate ()
    {
        //栏目所有数据
        $data = db('category')->select();
        //halt($data);
        //变为树状结构：所有数据、字段名称、主键id、父id
        return Arr::tree($data,'category_name','category_id','cate_pid');
    }

    /**
     * 获取除了自己和自己子集之外的数据
     */
    public function getCateData($id){
        //1.找到自己子集
        $cids = $this->getSon($id,db('category')->select());
        //halt($cids);
        //2.j将自己追加进去
        $cids[] = $id;
        //3.把自己和子集排除出去
        $res = db('category')->whereNotIn('category_id',$cids)->select();
        //halt($res);
        //将其转为树状结构
        return Arr::tree($res,'category_name','category_id','cate_pid');

    }
    /**
     * 寻找子集数据
     */
    public function getSon($id,$data)
    {
        static $temp = [];
        foreach($data as $k=>$v){
            if($id==$v['cate_pid']){
                $temp[] = $v['category_id'];
                $this->getSon($v['category_id'],$data);
            }
        }
        return $temp;
    }
}
