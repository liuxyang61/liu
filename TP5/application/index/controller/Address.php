<?php

namespace app\index\controller;

use think\Request;
use \app\common\model\Address as AddressModel;

class Address extends Common
{
    protected $user;
    public function  __construct(Request $request = null)
    {
        parent::__construct($request);
        if (empty(session('user'))) {
            $this->error('请先登录','index/login/index');
        }else{
            $this->user = session('user');
        }

    }

    /***
     * 收货地址列表
     */
    public function index(AddressModel $address)
    {
//        halt($this->user);
        $field =$address
            ->where('user_user_id',$this->user['user_id'])
            ->select();

//        halt($field);
        return view('',compact('field'));

    }

    /***
     * 添加收货地址方法
     * @return array|\think\response\View
     */
    public function post()
    {
        $address_id = input('param.address_id');
        $model = $address_id?AddressModel::find($address_id):new AddressModel();
//        halt($address_id);
        if (\request()->isAjax()) {

            $post = input('post.');
            $user=session('user');
//            dump($user);
            $post['user_user_id'] = $user['user_id'];
//            halt($post);
            //执行添加
            $res = $model->validate(true)->allowField(true)->save($post);
            if (false===$res){
                return ['valid'=>0,'message'=>$model->getError()];
            } else {
                return ['valid'=>1,'message'=>'操作成功'];
            }

        }

//        halt($model);
        if (empty($model['address_id'])) {
//            echo 1;die;
            $model = [
                "address_id"=> 0,
                "user_user_id" =>0,
                "ress_name" => '',
                "ress_city" => '',
                "ress_area" => '',
                "ress_county" => '',
                "ress_house" => '',
                "ress_code" => '',
                "ress_phone" => '',
            ];
        }
//        halt($model);
        return view('',compact('model'));
    }


    public function del()
    {
        $id = input('param.address_id');
        $res = AddressModel::destroy($id);
        if ($res) {
            return ['valid'=>1,'message'=>'操作成功'];
        }else{
            return ['valid'=>0,'message'=>'操作失败'];

        }

    }
}
