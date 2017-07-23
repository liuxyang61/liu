<?php namespace module\article\system;

use houdunwang\wechat\WeChat;
use module\base\model\Base_content;
use module\Hdprocessor;
use system\model\Article;

/**
 * 微信处理器
 * Class Processor
 * @package addons\stu\system
 */
class Processor extends Hdprocessor
{
    public function handler($id)
    {
        //测试是否已经走到这里
//        $this->text('arc');
        //正常输出arc
//          根据module_id在文章表中找对应数据
        $data = Article::find($id);
        //向用户回复图文消息
        $news=array(
            array(
                'title'=>$data['arc_title'],
                'discription'=>$data['arc_description'],
                'picurl'=>__ROOT__.'/'.$data['arc_thumb'],
                'url'=>__ROOT__."/{$data['arc_id']}.html"
            ),
        );
        //执行回复图文消息
        $this->news($news);



    }
}