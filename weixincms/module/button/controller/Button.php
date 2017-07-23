<?php namespace module\button\controller;

use houdunwang\db\Db;
use houdunwang\request\Request;
use houdunwang\wechat\WeChat;
use module\HdController;
use system\model\Button as ButtonModel;
class Button extends HdController
{

	public function index ()
	{
		$field = ButtonModel::get();
		return $this->template('',compact('field'));
	}

	//添加回复
	public function post ()
	{
		$id = Request::get('id');
		$model = ButtonModel::find($id) ? : new ButtonModel();
		if(IS_POST)
		{
			//p($_POST);die;
			$post = Request::post();
			if($id){
				$post['state'] = 0;
			}
			$model->save($post);
			return $this->setRedirect(url('button.index'))->success('操作成功');
		}
		//这里需要特殊考虑添加，在模板页面中button对应的就不存在，js报错
		if(!$id){
			$model = ['title'=>'','content'=>'[]'];
		}
		return $this->template('',compact('model'));
	}
	/**
	 * 删除
	 *
	 */
	public function del()
	{
		$id = Request::get('id');
		//p($id);die;
		//删除回复内容
		$model = ButtonModel::find($id);
		$model->destory();
		//成功提示
		return $this->setRedirect(url('button.index'))->success('操作成功');

	}



    public function push()
    {
        //接受get参数
        $id = Request::get('id');
//        p($id);
        //获取当前菜单数据
        $data = ButtonModel::find($id);
//        p($button);
        //获取菜单具体内容，推送需要
        $button['button'] =json_decode( $data->content,true);
//        p($data);die;
//        p($buttonContent);
       $res =WeChat::instance('button')->create($button);
        if($res['errcode']==0)
        {
            //推送成功
            //进行状态修改
            Db::table('button')->where("id",$id)->update(['state'=>1]);
            //把其他的菜单状态修改为0
            Db::table('button')->where("id",'<>',$id)->update(['state'=>0]);
            return $this->setRedirect(url('button.index'))->success('推送成功');
        }else{
            return $this->error('推送失败：'.$res['errmsg']);
        }
    }










}