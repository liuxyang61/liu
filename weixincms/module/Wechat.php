<?php
/**
 * Created by PhpStorm.
 * User: Mr.liu
 * Date: 2017/6/14
 * Time: 20:53
 */

namespace module;

use houdunwang\db\Db;
use houdunwang\request\Request;
use houdunwang\view\View;
use system\model\Keywords;

trait Wechat
{

    final protected function saveKeywords($data)
    {
        //关键词中的module字段没有值，需要在执行添加之前给值。
        //将关键词表中的module字段的值赋值为当前访问的地址中的模块参数
        $module = isset($data['module']) ? $data['module'] : Request::get('m');

        $where = [
            ['module_id', $data['module_id']],
            ['module', $module]
        ];
        //实例化keywords模型
        $keyWordsModel = Keywords::where($where)->first() ?: new Keywords();
        //执行save添加
        $data['module'] = $module;
        $keyWordsModel->save($data);


        //做出修改，因为之前代码有问题
//        $module = isset($data['module']) ? $data['module'] : Request::get('m');
//        $where = [
//            ['module_id',$data['module_id']],
//            ['module',$module]
//        ];
//        $keyWordsModel = Keywords::where($where)->first() ? : new Keywords();
//        $data['module'] = $module;
//        $keyWordsModel->save($data);
    }


    //删除方法
    public function delkeywords($id)
    {
        //wehere条件，并且关系存在，送一需要
        $where = [
            ['id', $id]
        ];
//        实例化模型，找到要删除的数据，
        $keywords = Keywords::where($where)->first() ?: new Keywords();
//        p($keywords);die;
        $keywords->destory();

    }


    final protected function assignKeywords($modeu_id)
    {
        $where = [
            ['module_id', $modeu_id],
            ['module', Request::get('m')]
        ];
        $keyWordsModel = Keywords::where($where)->first() ?: new Keywords();

        View::with('keywords', $keyWordsModel['keywords']);
    }


}