<?php

namespace app\index\controller;

use app\common\model\OrderList;
use think\Controller;
use think\Request;
use app\common\model\Orders as OrdersModel;
use houdunwang\cart\Cart;
use app\common\model\Address;
class Orders extends Common
{

    protected $user_id;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $user = session('user');
        $this->user_id = $user['user_id'];
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {

        $model=db('address')
            ->where('user_user_id',$this->user_id)
            ->select();
//        halt($model);
        $field = session('orders');
        return view('',compact('field','model'));

    }


    public function addOrders()
    {
        if(request()->isAjax()){
            if (empty(session('user'))) {
                return ['valid'=>0,'message'=>'未登录,前往登录？'];
        }

            //接受post数据
            $sid = input('post.sid');
//            halt($sid);
            //string(33) "fb3c808c4feb2018575f759d3113a93f|"
            //将最后|去掉，并且转为数组
            $sid = explode('|',rtrim($sid,'|'));
            //halt($sid);
            //根据sid从session中取出结算的数据
            //dc2d88ad4d47b16e33eec381d9483fa3
            $orderData = [];//接受订单数组
            $goods = session('cart.goods');
            //halt($goods);
            foreach ($sid as $k=>$v){
                $orderData['goods'][] = $goods[$v];
            }

            //halt($orderData);
            //计算结算商品总条数和总价
            $orderData['total_row'] = 0;
            $orderData['total_price'] = 0;
            foreach($orderData['goods'] as $k=>$v){
                $orderData['total_row'] += $v['num'];
                $orderData['total_price'] += $v['total'];
            }
            //halt($orderData);
            //将数据存入到session中
            session('orders',$orderData);
            return ['valid'=>1,'message'=>'正在结算'];
        }
    }



    /**
     * 立即下单
     */
    public function buyNow()
    {
//        halt($address_id);
        //将用户下单数据获取出来
        $ordersData = session('orders');
//        halt($ordersData);
        //添加订单表和订单列表
        $orders = new OrdersModel();
        $orders['time'] = time();
        $orders['number'] = Cart::getOrderId();
        $orders['total_price'] = $ordersData['total_price'];
        $orders['total_num'] = $ordersData['total_row'];
        $orders['status'] = 1;
        $orders['user_id'] = $this->user_id;
        $orders['address'] =input('post.id');
        $orders->save();
        //添加订单列表
        foreach($ordersData['goods'] as $k=>$v){
            $orderList = new OrderList();
            $orderList['goods_id'] = $v['id'];
            $orderList['goods_src'] = $v['options']['img'];
            $orderList['goods_name'] = $v['name'];
            $orderList['num'] = $v['num'];
            $orderList['total'] = $v['total'];
            $orderList['spec'] = $v['options']['color'] .'|' .$v['options']['size'];
            $orderList['orders_id'] =$orders->order_id;
            $orderList->save();
        }
        return ['valid'=>1,'message'=>'下单成功，去支付？'];
    }


    public function del()
    {
        if (\request()->isAjax()) {
            //接收订单id
            $order_id =  input('param.id')*1;
//            halt($order_id);
            //首先删除订单列表中的商品数据，再执行删除订单表
            $orders_list = db('orders')
                ->alias('o')
                ->join('order_list l',"o.order_id=l.orders_id")
                ->where('l.orders_id',$order_id)
                ->select();
//            halt($orders_list);
            $list_id = [];
            foreach ($orders_list as $k =>$v)
            {
                $list_id[]=$v['order_list_id'];
            }
//            halt($list_id);
            //删除订单列表数据
           $res =  db('order_list')->delete($list_id);
//            halt($res);
            //删除订单表数据
            $result = db('orders')->delete($order_id);

        }

        return ['valid'=>1,'message'=>'删除成功'];


    }
}
