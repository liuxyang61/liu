<?php namespace module;

use houdunwang\wechat\WeChat;
class Hdprocessor
{

    public function __call($name, $arguments)
    {
        $instance = WeChat::instance( 'message' );
        //$instance->text( 'aaaaasdfgh' );
        //(new $instance)->$name(var_export($arguments,true));
        //(new $instance)->$name(current($arguments));
        return call_user_func_array( [ new $instance , $name ] , [  current($arguments) ] );
    }
}