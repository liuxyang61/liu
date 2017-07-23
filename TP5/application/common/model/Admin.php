<?php

namespace app\common\model;

use think\Db;
use think\Model;

class Admin extends Model
{
    // // 设置当前模型对应的完整数据表名称
    protected $table = 'admin';

    public function changePassword($id,$post)
    {
        //接受需要修改的密码
        $admin = $Admin = Admin::get(['admin_id'=>$id]);
//        halt($admin['admin_password']);


        if ($post['admin_password']==$admin['admin_password']){

        }
    }

}
