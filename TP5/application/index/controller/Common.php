<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Session;

class Common extends Controller
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $cateData = $this->getCateData();
        $this->assign('cateData',$cateData);
        $cartData=$this->getCartData();
        $this->assign('cartData',$cartData);
        $userInfo = $this->getUserInfo();
        $this->assign('userInfo',$userInfo);
    }


    /**
     * 获取公共部分栏目数据
     * @return \think\response\View
     *
     */
    public function getCateData()
    {
        $cateData= db('category')->select();
        return $cateData;
    }

    /***
     * 获取购物车数据
     * @return mixed
     */
    public function getCartData()
    {
        $cartData = session('cart');
//        halt($cartData);
        if (empty($cartData)) {
            $cartData=[
                "total_rows"=> 0,
                "total_price" => 0,
            ];
        }
        return $cartData;

    }


    public function getUserInfo()
    {

        //获取登录后的用户信息
        $userInfo = Session::get('user');
//        halt($userInfo);
        if (empty($userInfo)) {
            $userInfo =  [
                'user_name'=>'',
                'user_id'=>0,
            ];

        }
        return $userInfo;
    }



}
