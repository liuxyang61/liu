<?php namespace system\model;
use houdunwang\db\Db;
use houdunwang\model\Model;
class Category extends Model{
	//数据表
	protected $table = "category";

	//允许填充字段
	protected $allowFill = ['*' ];

	//禁止填充字段
	protected $denyFill = [ ];

	//自动验证
	protected $validate=[
		//['字段名','验证方法','提示信息',验证条件,验证时间]
        ['cate_name','required','栏目名称不能为空',3,3],
        ['cate_description','required','栏目描述不能为空',3,3],
        ['cate_sort','required','栏目排序不能为空',3,3],
        ['cate_linkurl','required','栏目外部链接不能为空',3,3],
        ['cate_pid','isnull','栏目所属栏目不能为空',3,3],
	];

	//自动完成
	protected $auto=[
		//['字段名','处理方法','方法类型',验证条件,验证时机]
        ['cate_sort','intval','function',self::MUST_AUTO,self::MODEL_BOTH ],
	];

	//自动过滤
    protected $filter=[
        //[表单字段名,过滤条件,处理时间]
    ];

	//时间操作,需要表中存在created_at,updated_at字段
	protected $timestamps=true;

	//获取所有数据方法
    public function getAllCate()
    {
        //获取所有数据
//       return $this->get()->toArray();
        if ($this->get())
        {
            return Arr::tree($this->get()->toArray(), 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
        }else{
            return Arr::tree($this->get(), 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
        }


    }

    /***
     * 获取所有的子集和自己数据
     * @param $cate_id
     * @return mixed
     */
    public function getSonCateData($cate_id)
    {
        //1.递归找子集，
        $cids = $this->getSon($this->get(),$cate_id);
        if ($cids)
        {
            $cids = $this->getSon($this->get()->toArray(),$cate_id);
        }else{
            $cids = $this->getSon($this->get(),$cate_id);
        }


        //p($cids);
        //2.把自己追加进去
        $cids[] = $cate_id;
        //p($cids);
        //3.把自己和子集数据踢出去
        $res = $this->whereNotIn('cate_id',$cids)->get();
        if ($res)
        {
            $res = $this->whereNotIn('cate_id',$cids)->get()->toArray();
        }else{
            $res = $this->whereNotIn('cate_id',$cids)->get();
        }
//        p($res);die;
        return Arr::tree($res,'cate_name','cate_id','cate_pid');
    }

    /***
     * 获取所有的子集数据
     * @param $data
     * @param $cate_id
     * @return array
     */
    public function getSon($data,$cate_id)
    {
        //使用静态变量，不然每次调用自己的时候，$temp都是从空开始
        static $temp = [];
        foreach ($data as $k => $v) {
            if ($v['cate_pid'] == $cate_id) {
                //echo 1;
                //说明这条数据是我的儿子
                //把找到的这条数据对应的cid存起来
                $temp[] = $v['cate_id'];
                $this->getSon($data, $v['cate_id']);//接下来应该继续去找$v['cate_id'],它的子集数据
            }
        }
        return $temp;
    }


    public function del($cate_id)
    {
        //在这里执行删除数据动作
        //将数据删除，以及当前栏目的子集数据也删除
       $res =  Db::table('category')->where('cate_pid',$cate_id)->delete();
      $res =   Db::table('category')->where('cate_id',$cate_id)->delete();
      //将执行结果返回出去
        return ['valid'=>1,'msg'=>'删除成功'];


    }
}