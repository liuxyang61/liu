<?php
namespace app\index\controller;


use app\common\model\Goods;

class Index extends Common
{
    public function index()
    {
        $phoneData=$this->getPhoneData();
        $this->assign('phoneData',$phoneData);
        $ComputerData=$this->getComputerData();
        $this->assign('ComputerData',$ComputerData);

        return view();
    }


    /***
     * 商品分类页
     * @return \think\response\View
     */
    public function shop()
    {
        $id = input('param.category_id');
//        dump($id);
        $goodsData = db('category')
            ->alias('c')
            ->join('goods g','c.category_id=g.category_category_id')
            ->where('g.category_category_id',$id)
            ->where('is_recovery',0)
            ->select();
//        dump($goodsData=compact('goodsData',$goodsData));

        if (empty($goodsData)) {
//            echo 1;die;
            $category_name='暂无商品请添加';
            $this->assign('category_name',$category_name);
        }
//          halt($goodsData);
        return view('',compact('goodsData',$goodsData));
    }

    /***
     * 商品内容页
     * @return \think\response\View
     */
    public function content()
    {

        $goods_id=input('param.goods_id');
        //获取商品数据
        $goodsDate= Goods::find($goods_id);
//
        $goodsDate['goods_src']=explode('|',$goodsDate['goods_src']);
        $goodsDate['goods_color']=explode('|',$goodsDate['goods_color']);
        $goodsDate['goods_size']=explode('|',$goodsDate['goods_size']);
//        halt($goodsDate);
        return view('',compact('goodsDate',$goodsDate));
    }


    /***
     * 获取商品数据
     */
    public function getPhoneData()
    {
        $phoneData = db('goods')
            ->where('category_category_id',1)
            ->limit(10)
            ->select();
//        halt($goodsData);
        return $phoneData;
    }


    public function getComputerData()
    {
        $ComputerData = db('goods')
            ->where('category_category_id',2)
            ->limit(7)
            ->select();
//        halt($goodsData);
        return $ComputerData;
    }



    public function search()
    {
        $content = input('param.content');

//        halt($content);
        $goodsData = db('goods')
            ->where('goods_name','like','%'.$content.'%')
            ->select();
//        halt($goodsData);





        return view('',compact('goodsData',$goodsData));
    }
}
