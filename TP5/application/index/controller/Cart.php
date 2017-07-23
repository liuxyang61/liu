<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Cart extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data=session('cart');
//        halt($data);
        return view('',compact('data'));
    }


    public function addCart()
    {

        if (\request()->isAjax()) {
            $post=input('post.');
//            halt($post);
            $post['options'] = explode('|',rtrim($post['options'],'|'));
//            halt($post['options']);
            $data = [
                'id'      => $post['goods_id'] , // 商品 ID
                'name'    => $post['goods_name'] ,// 商品名称
                'num'     => $post['num'] , // 商品数量
                'price'   => $post['price'] , // 商品价格
                'options' => [
                    'color' => $post['options'][0],
                    'size'  => $post['options'][1],
                    'img'=>$post['img'],
                ]// 其他参数如价格、颜色、可以为数组或字符串
            ];

            \houdunwang\cart\Cart::add($data);
            return ['valid'=>1,'message'=>'已添加,前往购物车结算?'];
        }
    }


    /**
     * 更新购物车
     */
    public function updateCart()
    {
//		halt(input('post.'));
//		$data=array(
//			'sid'=>'4d854bc6',// 唯一 sid，添加购物车时自动生成
//			'num'=>88
//		);
        \houdunwang\cart\Cart::update(input('post.'));
        return session('cart');
    }

    /**
     * 删除
     */
    public function delCart()
    {
        $sid = input('post.sid');
        //halt($sid);
        $data = session('cart');//这是购物车数据
        //halt($data['goods'][$sid]);
        //删除$data数据
        unset($data['goods'][$sid]);
        //删除之后会导致total_rows和total_price不正确
        $data['total_rows'] = 0;
        $data['total_price'] = 0;
        foreach ($data['goods'] as $k=>$v){
            $data['total_rows'] += $v['num'];
            $data['total_price'] += $v['total'];
        }
        //重新赋值回session
        session('cart',$data);
        return session('cart');
    }


    /***
     * 商品列表页添加购物车方法
     */
    public function shopAddCart()
    {
        if (\request()->isAjax()) {
            $id = input('post.id');
//            halt($id);
            $cartData = db('goods')->find($id);
//            dump($cartData);
            $cartData['goods_color'] = explode('|',$cartData['goods_color']);
            $cartData['goods_size'] = explode('|',$cartData['goods_size']);
//            halt($cartData);
            $data = [
                'id'      => $cartData['goods_id'] , // 商品 ID
                'name'    => $cartData['goods_name'] ,// 商品名称
                'num'     => 1 , // 商品数量
                'price'   => $cartData['goods_price'] , // 商品价格
                'options' => [
                    'color' => $cartData['goods_color'][0],
                    'size'  => $cartData['goods_size'][0],
                    'img'=>$cartData['goods_thumb'],
                ]// 其他参数如价格、颜色、可以为数组或字符串
            ];

            \houdunwang\cart\Cart::add($data);
            $CartData = session('cart');
            return ['valid'=>1,'message'=>'已添加,前往购物车结算?','total_rows'=>$CartData['total_rows'],'total_price'=>$CartData['total_price']];

        }


    }

}
