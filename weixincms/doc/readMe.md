
>hdjs手册：hdjs.hdphp.com

>密码修改

>调整布局

    1.原来将微信功能跟文章管理写一起，修改每一个功能是一个app一个独立模块
    2.微信公众号配置（wechat）：
        |--Config::set()直接设置的话，会将框架配置项中的数据完全覆盖掉
        |--需要我们设置配置和框架配置像优先级问题【就是需要两个都留下，我们优先级高于系统】
        |--中间件中设置微信配置项地方稍有变动
    3.测试微信绑定，以及消息恢复
        |--如果之前修改过houdunwang/wechat,找到目录删除，执行composer require houdunwang/wechat重新下载
        |--微信模块下新建Api.php进行微信绑定测试以及消息恢复管理
        
>模块设计
    
    1.调整布局
    2.module系统模块，系统基础功能在里面
        |--HdController.php，   控制器公共控制器
        |--HdProcessor.php   微信处理器公众类
    3.addons[插件目录]
        pic[插件标识]
            |--controller
            |--model
            |--system   
                |--Processor.php  微信处理器
            |--template 模板目录
    4.插件设计功能
        |--生成基本目录机构和创建基本文件
            |--验证
            |--模块不能重复创建
            |--生成基本目录结构
            |--创建出基本文件
        |--写入数据库

##2017年06月14日09:23:19星期三

>composer自动加载

    1.composer.json文件中autoload里面
         "autoload": {
            "files": [
              "system/helper.php"
            ],
            "psr-4": {
              "app\\": "app",
              "system\\": "system",
              "addons\\": "addons",
              "module\\": "module",
              "wubin\\":"wubin"
            }
          },
    2.在终端里面执行composer dump，确保有文件上传
    
>实例化addons或module类

    1.框架默认不会识别app意外目录，进行个性化定制
    2.希望通过这种get参数来进行访问：?m=pic&action=controller/index/index【m:模块，action:controller/控制器/方法】
    3.最终执行：(new \addons\pic\controller\Index())->add();，这时候一定需要通过composer.json进行配置自动加载
    4.框架默认不识别我们自己加的这些参数，后面工作在home/entry/index中进行
    5.在home/entry/index，完成运行模块
        $res = $this->runModule();
        //1.7这个判断：当运行了模块中的类方法，就不让代码继续往下走了
        if ( $res !== false ) {
        	return $res;
        }
    5.在home/entry/index，增加方法：runModule
        $m = Request::get( 'm' );
        $action = Request::get( 'action' );
        if ( $m && $action ) {
            $info = explode( '/' , $action );
            $class = 'addons' . "\\" . $m . '\\' . $info[ 0 ] . '\\' . ucfirst( $info[ 1 ] );
            return call_user_func_array( [ new $class , $info[ 2 ] ] , [] );
        }
        return false;
    6.考虑模块如果不存在，那么肯定实例化不到，对5步骤中增加：
            $m = Request::get( 'm' );
            //这一步为新增加的内容
            $module = Module::where( 'module_name' , $m )->first();
            $action = Request::get( 'action' );
            //这里判断原来：if ($m && $action ) {，将其修改为以下：
            if ($module && $m && $action ) {
                $info = explode( '/' , $action );
                //考虑不仅要实例化addon里面的类，还需要实例化module【系统】类
                //需要手动给数据库增加一条module_is_system=1数据，数据跟module中的模块保持一致即可
                $class = ( $module[ 'module_is_system' ] == 1 ? 'module' : 'addons' ) . "\\" . $m . '\\' . $info[ 0 ] . '\\' . ucfirst( $info[ 1 ] );
                return call_user_func_array( [ new $class , $info[ 2 ] ] , [] );
            }
            return false;
    7.最终目的：通过改变地址栏的m参数和action参数，能分别访问到addons或module中类方法    

>模块中加载模板处理
    
    1.return view()，这样不能加载到我们需要的模板文件
    2.return view('module/base/template/base/index.php'); 可以正常加载我们需要的模板
    3.对第二部进行升级，放在公众控制器中
        //'module/base/template/base/index.php'参数进行替换
        protected $template;
        public function __construct ()
        	{
        		$m = Request::get( 'm' );
        		//根据地址栏m参数，查出来结果中module_is_system知道是不是系统模块
        		$module         = Module::where( 'module_name' , $m )->first();
        		$this->template = ( $module[ 'module_is_system' ] == 1 ? 'module' : 'addons' ) . '/' . $m . '/template/';
        
        		//		return view( $this->template );
        	}
        //加载模板文件
        	protected function template ( $tpl = null )
        	{
        		$info = explode( '/' , Request::get( 'action' ) );
        		$tpl  = is_null( $tpl ) ? $info[ 2 ] : $tpl;
        
        		//info[1]控制器类，$info[ 2 ]值得是方法
        		return view( $this->template . strtolower( $info[ 1 ] ) . '/' . $tpl );
        	}


>封装模块跳转函数url函数

    1.函数放在system/helper.php中，这个文件会被框架自动加载
    2.当我们使用url('wx.index')时候，执行完成这个函数最终给我返回：return "?m=base&action=controller/wx/index";
    if ( !function_exists( 'url' ) ) {
    	/**
    	 * 跳转模块url跳转函数
    	 * @param $url				跳转地址：控制器.方法
    	 * @param string $module	跳转模块	 默认都get中m参数
    	 *
    	 * @return string
    	 */
    	function url ( $url , $module = '' )
    	{
    		//如果$model这个参数为真，说明调用url时候，有传$module这个参数，以传入的为准
    		//如果没有穿第二个参数，默认使用get参数中m参数的值
    		$module = $module ? : Request::get('m');
    		//p($module);//base
    		//p($url);//wx.index
    		//return "?m=base&action=controller/wx/index";
    		return __ROOT__ ."?m=".$module."&action=controller/" . str_replace('.','/',$url);
    	}
    }

>完成添加基本回复的添加功能

       1.搞定添加和展示页的模板文件
       2.触发关键词提取出来公共部分提取出来放在resource/view/keywords.php
       3.使用系统include标签将其加载过去
       4.创建数据表关键词【keywords】和回复内容【base_content】
       5.对应模型创建，BaseContent的模型放在module/base/model/BaseContent.php，注意修改命名空间
       6.在post方法中执行添加
                    $baseModel = new BaseContent();
            		if(IS_POST)
            		{
            			$post = Request::post();
            			//p($post);
            			//添加回复表
            			$baseModel->save($post);
            			//添加关键词表
                        (new Keywords())->save($post);
            		}
       7.看那个字段没有进入数据表，进行修改
            		$baseModel = new BaseContent();
            		if(IS_POST)
            		{
            			$post = Request::post();
            			//p($post);
            			//添加回复表
            //var_dump($baseModel['id']);//NULL
            			$baseModel->save($post);
            //var_dump($baseModel['id']);//2
            			//添加关键词表
            //$post['module_id'] = $baseModel['id'];
            //$post['module'] = Request::get('m');
            			(new Keywords())->save($post);
            
            		}
        8.在module创建trait Wechat类
            final protected function saveKeywords($data)
            	{
            		$data['module'] = Request::get('m');
            		$keyWordsModel = new Keywords();
            		$keyWordsModel->save($data);
            	}
        9.想要用它，在HdController类里面 use Wechat
        10.Wx.php只需要继承HdController,就可以用到saveKeywords方法
                


##模块跳转函数url函数
```
/**
  * 跳转模块url跳转函数
  * @param $url				跳转地址：控制器.方法
  * @param string $module	跳转模块	 默认都get中m参数
  *
  * @return string
  */
  function url ( $url , $module = '' )
```
使用方法
```
    url('控制器.方法',$module = '模块');
```
生成以下链接
```
   ?m=模块&action=controller/控制器/方法
```


##2017年06月16日11:20:40星期五

>（一）微信功能中关键词回复
    
    1.app\wechat\controller\Api -->handler
        $instance = Wechat::instance( 'message' );
        $content = $instance->Content;
        $module = Keywords::where( 'keywords' , $content )->first();
        if ( $module ) {
        		$module_is_system = Module::where( 'module_name' , $module['module'] )->pluck( 'module_is_system' );
        		$class = ( $module_is_system == 1 ? 'module' : 'addons' ) . '\\' . $module['module'] . '\system\Processor';
        		return call_user_func_array( [ new $class , 'handler' ] , [$module['module_id']] );
        }
    2.在微信测试回复关键词的时候，module\base\system\Processor
        $content = BaseContent::find($module_id);
        $this->text($content['content']);
    3.在module\HdProcessor,增加__call
        /**
        	 * 魔术方法，调用一个未找到的方法时候，会自动触发
        	 *
        	 * @param $name                未找到的方法名称
        	 * @param $arguments
        	 */
        	public function __call ( $name , $arguments )
        	{
        		$instance = WeChat::instance( 'message' );
        		return call_user_func_array( [ new $instance , $name ] , [  current($arguments) ] );
        	}
    
>（二）微信模块中系统回复

    1.在congfig表中增加一个存储微信系统回复字段，新增加一个修改迁移文件
    2.正常执行添加编辑
    
>（三）处理默认回复
 
    1.在第一步中关键词回复下面增加默认回复
    
> (四) 处理文章中微信关键词

    1.在文章添加方法中增加代码，能让这个关键词添加到关键词表，注意导入 use module\Wechat
        $data = ['keywords'=>$post['arc_keyword'],'module_id'=>$arc_id,'module'=>'article'];
        $this->saveKeywords($data);
    2.注意修改saveKeywords方法
        $module = isset($data['module']) ? $data['module'] : Request::get('m');
        
    3.在module数据表中增加一个article模块，系统模块
    4.在module目录中创建article模块system.Processor
    5.测试图文消息
    6.图文消息中点击图文跳转原文地址没有，所以我们去到了app\home\entry\,书写了content方法
    7.IS_MOBILE常量、模板放在template、伪静态

>如果你的默认回复内容恰好是关键词，那么回复给粉丝该关键词对应的内容

    1.$instance = Wechat::instance( 'message' );
              $content = $instance->Content;
              $module = Keywords::where( 'keywords' , $content )->first();
              if ( $module ) {
              		$module_is_system = Module::where( 'module_name' , $module['module'] )->pluck( 'module_is_system' );
              		$class = ( $module_is_system == 1 ? 'module' : 'addons' ) . '\\' . $module['module'] . '\system\Processor';
              		return call_user_func_array( [ new $class , 'handler' ] , [$module['module_id']] );
              }
              //默认回复
              		//在config表中回去字段为wechat_system_response值
              		$wechat_system_response= Config::find(1)->wechat_system_response;
              		//将其转为数组格式
              		$wechat_system_response = json_decode($wechat_system_response,true);
              
              		//获取默认回复的消息内容default_message
              		//如果你默认回复消息，恰好是一个关键词，那么当你随便输入的时候，回复该关键词对应的内容
              		//去除默认消息进行恢复给粉丝
              		$instance->text($wechat_system_response['default_message']);
    2.将上一步中代码修改为
        //1.测试回复消息是否正常
        		$instance = Wechat::instance( 'message' );
        		//$instance->text('aaaa');
        		//2.根据粉丝发来的消息内容，在关键词表找对应模块，再模块表中看当前模块是不是系统模块，然后进行实例化微信处理器
        		//2.1获取粉丝发送来的消息内容,【关键词】
        		$content = $instance->Content;
        		
        		$this->parseKeywords($content);
        		
        		//默认回复
        		//在config表中回去字段为wechat_system_response值
        		$wechat_system_response= Config::find(1)->wechat_system_response;
        		//将其转为数组格式
        		$wechat_system_response = json_decode($wechat_system_response,true);
        		//获取默认回复的消息内容default_message
        		//如果你默认回复消息，恰好是一个关键词，那么当你随便输入的时候，回复该关键词对应的内容
        		$this->parseKeywords($wechat_system_response['default_message']);
        		//去除默认消息进行恢复给粉丝
        		$instance->text($wechat_system_response['default_message']);
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






