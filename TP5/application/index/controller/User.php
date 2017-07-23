<?php

namespace app\index\controller;

use app\common\model\OrderList;
use think\Controller;
use think\Request;
use app\common\model\Orders;
use think\Session;

class User extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //

        return view();
    }

    public function orders()
    {
        $user_id = session('user.user_id');
//        dump($user_id);
        $orders = db('orders')
            ->alias('o')
            ->join('address a','o.address=a.address_id')
            ->where('o.user_id',$user_id)
            ->select();
//        dump($orders);
//        foreach ($orders as $kk =>$vv){
//
//            if ($vv['status']==1){
//                $vv['status']='未支付';
//            }elseif($vv['status']==2){
//                $vv['status']='已发货';
//            }elseif($vv['status']==3){
//                $vv['status']='已签收';
//            }elseif($vv['status']==4){
//                $vv['status']='已完成';
//            }
//        }
        foreach ($orders as $k => $v){

            $order_listData =   db('order_list')
               ->where('orders_id',$v['order_id'])
               ->select();
            $orders[$k]['order_listData']=$order_listData;
            $orders[$k]['time']=date('Y-m-d H:i:s',$orders[$k]['time']);
//                dump(compact('order_listData'));
            switch ($orders[$k]['status'])
            {
                case 1;
                    $orders[$k]['status']='待支付';
                    break;
                case 2;
                    $orders[$k]['status']='已发货';
                    break;
                case 3;
                    $orders[$k]['status']='已签收';
                    break;
                case 4;
                    $orders[$k]['status']='已完成';
                    break;
                    default:
                        break;
            }



        }
//        dump($orders);

        return view('',compact('orders'));
    }


    /***
     * 退出登录
     */
    public function out()
    {
        Session::delete('user');
        $this->redirect('/index/login/index');
    }
}
