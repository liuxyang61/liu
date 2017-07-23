<?php namespace app\wechat\controller;

use houdunwang\route\Controller;
use houdunwang\wechat\WeChat;
use system\model\Keywords;
use system\model\Module;

/**
 * 微信通讯验证
 * Class Api
 * @package app\wechat\controller
 */
class Api extends Controller{
    public function __construct ()
    {

//	    echo 1;die;
        //验证微信通讯,在与微信通讯验证之前，需要注意：在中间件中进行Config::set('wechat')，这一步动作
        WeChat::valid();
    }

    //动作
    public function handler()
    {

        //删除菜单
//        WeChat::instance('button')->flush();

        //测试消息发送
        $instance =WeChat::instance('message');
        //获取微信默认回复消息
        $default = v('base.default');
        //粉丝关注回复
        if ($instance->isSubscribeEvent())
        {
            //向用户回复消息
            $instance->text(v('base.primary'));
        }
        //如果是文本消息，那么将查看是否是关键词消息
        if ($instance->isTextMsg())
        {
            //接受粉丝发送的消息，
            $content = $instance->Content;
            //查看是否为关键词，需要去到keywords表和keywords字段进行对比
            //执行消息验证，查看是否为关键词
            $this->parseKeywords($content);
            //走到这里说明不是关键词，那么将默认回复的内容再进行

            //执行是否为关键词。
            $this->parseKeywords($default);

        }

        //按钮点击事件
        $button = WeChat::instance('button');
        if($button->isClickEvent())
        {
            //将粉丝消息进行关键词验证
//            $key = $instance->EventKey;
//            $instance->text($key);
            $this->parseKeywords($instance->EventKey);

        }else{

        }
        //获取默认消息进行恢复给粉丝
        $instance->text($default);

    }

    protected function parseKeywords($content)
    {
        //将粉丝发来的消息，原样回复回复，测试
        //$instance->text($content);
        //2.2在关键词表中根据关键词找模块，pluck是获取单一一个字段的值
        //$module = Keywords::where( 'keywords' , $content )->pluck( 'module' );
        //相当于：select name from student
        $module = Keywords::where( 'keywords' , $content )->first();
        if ( $module ) {
            //2.3模块表中查找2.2中的模块是不是系统模块
            $module_is_system = Module::where( 'module_name' , $module['module'] )->pluck( 'module_is_system' );
            //$instance->text($module_is_system);
            //$class = "module\base\system\Processor"
            //$class = "addons\pic\system\Processor";
            $class = ( $module_is_system == 1 ? 'module' : 'addons' ) . '\\' . $module['module'] . '\system\Processor';
            return call_user_func_array( [ new $class , 'handler' ] , [$module['module_id']] );
        }
    }
}
