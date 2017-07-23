<?php namespace module\base\system;

use houdunwang\wechat\WeChat;
use module\base\model\Base_content;
use module\Hdprocessor;

/**
 * 微信处理器
 * Class Processor
 * @package addons\stu\system
 */
class Processor extends Hdprocessor
{
	public function handler($id)
	{
////	    echo 1;die; 1;能输出出来
//        //实例化微信消息类
//	    $instance = WeChat::instance('message');
//	    //回复消息
////	    $instance->text($id); ///3
//        //到base——content表中去找和关键词module_id关联的回复内容，
//        $basecontent = Base_content::where('id',$id)->first();
//        //将关联的回复内容给粉丝回复过去；
//        $instance->text($basecontent['content']);


        //根据module_id在回复表中会的回复内容
        $content = Base_content::find($id);
        //这个方法在类找不见，父类有__call魔术方法
        $this->text($content['content']);

    }
}