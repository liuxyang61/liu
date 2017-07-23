<?php namespace addons\links\system;

class Tag
{
    public function links($attr,$content)
    {

        //这里将将进行数据的交互.
        $row = isset($attr['row']) ? $attr['row'] : -1;
        $str = <<<str
<?php
	\$db = Db::table('addons_links')->orderBy('links_orderby','desc');
	if($row>0){
		\$db->limit($row);
	}
	\$data = \$db->get();
	foreach(\$data as \$v):
?>
	$content
<?php 
	endforeach
?>
str;

        return $str;
    }


}