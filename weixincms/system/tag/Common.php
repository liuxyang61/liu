<?php namespace system\tag;
use houdunwang\request\Request;
use houdunwang\view\build\TagBase;

class Common extends TagBase {
	/**
	 * 标签声明
	 * @var array
	 */
	public $tags = [
            'prev'     => [ 'block' => false ] ,
            'next'     => [ 'block' => false ] ,
			'tag'  => [ 'block' => true, 'level' => 4 ],
			'category'  => [ 'block' => true, 'level' => 4 ],
			'slide'  => [ 'block' => true, 'level' => 4 ],
			'article'  => [ 'block' => true, 'level' => 4 ],

	];
	//tag 标签
	public function _tag( $attr, $content, &$view ) {
        //首先确认需要的模块和方法,
       $info = explode('.',$attr['action']);
       $addons_module = $info[0];//0号参数为需要调用的模型
        $action = $info[1];//1号参数为请求的方法，用于页面使用.

        //核心思想，实例化插件中的system/tag中的方法，获取具体数据。
        $class = ($moduleData['module_is_system']==1 ? 'module': 'addons') .'\\' .$addons_module . '\system\Tag';

		return (new $class)->$action($attr, $content);
	}


	//categroy标签
    public function _category($attr, $content, &$view)
    {
        $pid = isset($attr['pid']) ? $attr['pid']  : -1;
        //看解析成了什么，看编译文件
        //转义不转义变量
        $str = <<<str
				<?php
					\$db= Db::table('category');
					if($pid>=0){
						\$db->where('cate_pid',$pid);
					}
					\$cateData = \$db->get();
					foreach(\$cateData as \$v):
				?>
					$content
				<?php
					endforeach
				?>
str;

        return $str;
    }

    //轮播图标签
    public function _slide($attr, $content, &$view)
    {

        //将所有图片信息循环出来
        $str = <<<str
            <?php
            \$slideData= Db::table('slide')->get();
            foreach(\$slideData as \$v ){
            ?>
                    $content
            <?php 
            }
            ?>
str;
        return $str;
    }

    //文章列表
    public function _article($attr, $content, &$view)
    {
        $cid = isset($attr['cid'])?$attr['cid']: (Request::get('cate_id')?:-1);
        $thumb = isset($attr['thumb'])?$attr['thumb']: -1;
        $row = isset($attr['row'])?$attr['row']: -1;
        //声明变量循环文章数据
        $str = <<<str
            <?php
            \$db = Db::table('article')->orderBy('arc_orderby','DESC');  
            if($cid>=0)
            {
                 \$db->where('cate_cid',$cid);
            }
            if($thumb==1)
            {
                  \$db->where('arc_thumb','<>',''); 
            }
            if($row>=0)
            {
                   \$arcData = \$db->paginate($row);
            }else{
             \$arcData = \$db->get();
            }
            
            foreach(\$arcData as \$v){
            ?>
            $content
            <?php
            }
            ?>
            
str;

        return $str;

    }



    public function _next ( $attr , $content , &$view )
    {
        $str = <<<str
			<?php
			\$arc_id = Request::get('arc_id');
			\$data = Db::table('article')->where('arc_id','>',\$arc_id)->orderBy('arc_id','ASC')->first();
			if(\$data){
				echo "<a class='next' href='".\$data['arc_id'].".html"."'>{\$data['arc_title']}</a>";
			}else{
				echo '无';
			}
			?>
str;

        return $str;
    }

    //上一篇
    public function _prev ( $attr , $content , &$view )
    {
        $str = <<<str
			<?php
			\$arc_id = Request::get('arc_id');
			\$data = Db::table('article')->where('arc_id','<',\$arc_id)->orderBy('arc_id','DESC')->first();
			if(\$data){
				echo "<a class='prev' href='".\$data['arc_id'].".html"."'>{\$data['arc_title']}</a>";
			}else{
				echo '无';
			}
			?>
str;

        return $str;
    }
}