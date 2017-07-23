### CMS系统介绍
>HDCMS官方手册： hdphp.com



>HDCMS文章管理系统手册,主要展示具体核心文件，和具体代码。如有问题，请联系：18201053853;   联系人：刘阳。


>app   //程序应用目录

    1.admin //后台系统管理
        |--controllor //控制器
            |--1.1  Article.php //文章管理控制器
                |--/**
                    * 文章控制器
                    * Class Article
                    * @package app\admin\controller
                    */
                   class Article extends Common  //继承Common 总控制器类
                   {
                       //这里把wechat关键词类，引进来
                       use Wechat;
                       public function __construct()
                       {
                           //引入common中auth方法，在auth方法中执行system\Middleware\Auth.php这个中间件
                           //该中间件才是登录验证代码书写的地方
                           $this->auth();
                       }
                       //动作
                       public function index(ArticleModel $article)
                       {
                           //这里引入框架里面的分页方法,把显示每页的条数，放到系统配置页面上，方便用户自己操作
                           $field = $article->paginate(v('config.article_num'));
                           //p($field);die;
                           //加载模板，并且分配变量
                           return view('', compact('field'));
                       }
                       /**
                        * 编辑和添加
                        */
                       public function post(ArticleModel $article, Category $category)
                       {
                           //引入Request获取get里面的所有参数，并且把字符串转为整数型
                           $arc_id = Request::get('arc_id', 0, 'intval');
                           if (IS_POST) {
                               if ($arc_id) {
                                   //引入system\model\Article 里面的方法，find是找到主键 是$arc_id的数据
                                   $article = ArticleModel::find($arc_id);
                               }
                               //获取post所有数据，
                               $post = Request::post();
                               //将获得post的所有数据数据存储到文章表
                               $article->save($post);
                               //添加关键词表数据
                               $data = ['keywords' => $post['arc_keyword'], 'module_id' => $arc_id, 'module' => 'article'];
                               //p($data);die;
                               //引入wechat里面的基本回复saveKeywords方法，把存到$data里面的数据传进去
                               $this->saveKeywords($data);
                               //p(Request::post());die;
                               //成功的提示信息，和跳转的页面
                               $this->setRedirect('index')->success('操作成功');
                           }
                           if ($arc_id) {
                               //编辑。find是找到这个数据里的那条id 的主键
                               $oldData = ArticleModel::find($arc_id);
                               //p($oldData);die;
                           }
                           //获取栏目所属的数据
                           $cateDate = $category->getAllCate();
                           //p($cateDate);die;
                           //把获得的旧数据return出去
                           return view('', compact('cateDate', 'oldData'));
                       }
                       /**
                        * 删除
                        */
                       public function del(ArticleModel $article)
                       {
                           //获取get所有数据的arc_id
                           $arc_id = Request::get('arc_id');
                           //p($arc_id);die;
                           //执行删除
                           $model = ArticleModel::find($arc_id);
                           //p($model);die;
                           //在Keywords表中找到$model数据中中对应的关键词的那一条数据，
                           $keyword = Keywords::where('keywords', $model['arc_keyword'])->first();
                           $keyword->destory();
                           $model->destory();
                           //跳转地址，成功的提示信息
                           return $this->setRedirect('index')->success('操作成功');
                       }
                       

            |-- 1.2 Category.php //栏目管理控制器
                |--namespace app\admin\controller;  //命名空间
                   use houdunwang\request\Request;  //  引入houdunwang/Request 的命名空间
                   use system\model\Category as CategoryModel;  //引入Category 模块的命名空间 这里的类也是Category 所有要起别名
                   /**
                    * 栏目管理控制器
                    * Class Category
                    * @package app\admin\controller
                    */
                   class Category extends Common //继承Common 总控制器类
                   {
                       public function __construct ()
                       {
                           //引入common中auth方法，在auth方法中执行system\Middleware\Auth.php这个中间件
                           //该中间件才是登录验证代码书写的地方
                           $this->auth();
                       }
                       //栏目首页
                       public function index ( CategoryModel $category )
                       {
                           //getAllCate 获取数据库的所有数据，
                           $cateData = $category->getAllCate();
                           //p($cateData);die;
                           //加载模板，并且分配变量
                           return view('',compact('cateData'));
                       }
                       /**
                        * 栏目添加
                        */
                       public function post ( CategoryModel $category )
                       {
                           //接受参数
                           $cate_id = Request::get('cate_id',0,'intval');
                           //p($cate_id);
                           if ( IS_POST ) {
                               if($cate_id){
                                   //编辑
                                   $category = CategoryModel::find($cate_id);
                               }
                               //添加
                               //p($_POST);die;
                               //Request::post()接受post提交的所有数据
                               $category->save( Request::post() );
                               return message( '操作成功' , 'index' );
                           }
                           //处理旧数据
                           if($cate_id){
                               //编辑功能
                               $oldData = CategoryModel::find($cate_id);
                               //p($oldData->toArray());die;
                               View::with('oldData',$oldData);
                               //所属分类数据，不能选择自己+自己所有子集
                               $cateData = $category->getSonCateData($cate_id);
                               //p($cateData);
                           }else{
                               //获取栏目所有数据，数据要放在添加页面中所属栏目
                               $cateData = $category->getAllCate();
                               //p($cateData);
                           }
                           //分配变量
                           View::with( 'cateData' , $cateData );
                           return view();
                       }
                       /**
                        * 删除
                        */
                       public function del(CategoryModel $category)
                       {
                           $cate_id = Request::get('cate_id');
                           if($category->del($cate_id))
                           {
                               //把 成功的消息return出去
                               return $this->setRedirect('index')->success('处理成功');
                           }else{
                               //这里的getError是引入模型中的方法。获取错误信息
                               return $this->error($category->getError());
                           }
                       }
                   
                   
            |-- 1.3 Common.php // 总控制器
                |--namespace app\admin\controller; //命名空间
                   use houdunwang\route\Controller;  // 引入houdunwang\route\Controller的命名空间
                   abstract class Common extends Controller //继承houdunwang\route里面的Controller
                   {
                       //执行中间件，进行登录验证
                       //final 是最终意思，不允许子类重写auth方法
                       //加上final之后，如果子类出现auth方法，就会报错
                       final public function auth()
                       {
                           Middleware::set('auth');
                       }
                   }
                   
                   
            |-- 1.4 Config.php //系统管理控制器
                |-- namespace app\admin\controller;  //命名空间
                   use houdunwang\request\Request;  // 引入houdunwang\request\Request的命名空间
                   use system\model\Config as ConfigModel;  //引入模块Config的命名空间 因为和类同名所以必须起别名
                   /**
                    * 系统控制器
                    * Class Config
                    * @package app\admin\controller
                    */
                   class Config extends Common {
                       public function __construct ()
                       {
                           //引入common中auth方法，在auth方法中执行system\Middleware\Auth.php这个中间件
                           //该中间件才是登录验证代码书写的地方
                           $this->auth();
                       }
                       //动作
                       public function setting(ConfigModel $config){
                           if (IS_POST)
                           {
                               //这里引入  system/model/Category/setConfig 方法，接受post所有数据
                               $config ->setConfig(Request::post());
                               //把成功的提示 return出去。
                               return $this->setRedirect('refresh')->success('操作成功');
                           }
                           //获取数据库的数据
                           $model = ConfigModel::find(1);
                           //这个判断，如果能找到数据，将其转为数组，并且分配到页面 如果找不到，给一个默认空数组
                           $field = $model ? json_decode($model['system'],true) : [];
                           return view('',compact('field'));
                       }
                   
                   
            |--1.5 Entry.php // 后台登录管理控制器
                |--namespace app\admin\controller;  //命名空间
                   use houdunwang\request\Request;  // 引入houdunwang\request\Request 的命名空间
                   use system\model\Admi;  //引入Admi 模块的命名空间
                   /**
                    * 后台登录管理
                    * Class Entry
                    * @package app\admin\controller
                    */
                   class Entry extends Common
                   {
                       public function __construct ()
                       {
                           //引入common中auth方法，在auth方法中执行system\Middleware\Auth.php这个中间件
                           //该中间件才是登录验证代码书写的地方
                           $this->auth();
                       }
                       public function index()
                       {
                           //加载模板
                           return View::make();
                       }
                       //修改密码
                       public function changePassword(Admi $admi)
                       {
                           if (IS_POST)
                           {
                                // 调用changePassword 方法获取 post 提交的所有数据
                               return $admi->changePassword(Request::post());
                           }
                           return view();
                       }
                   
                   
            |-- 1.6 Login.php // 登录管理控制器
                |--namespace app\admin\controller;  // 命名空间
                   use system\model\Admi;  // 引用 Admi 模块的命名空间
                   /**
                    * 登录管理控制器
                    * Class Login
                    * @package app\admin\controller
                    */
                   class Login
                   {
                       public function index(Admi $admi)
                       {
                           //测试password_hash函数，
                           //$password = password_hash('admin888',PASSWORD_DEFAULT);
                           //echo $password;die;
                           if (IS_POST)
                           {
                               $res = $admi->Login();
                               if ($res['valid'])
                               {
                                   //执行成功
                                   return message($res['msg'],'admin.entry.index','success');
                               }else{
                                   //执行失败
                                   return message($res['msg'],'back','error');
                               }
                           }
                           return View::make();
                       }
                       /**
                        * 验证码
                        */
                       public function code()
                       {
                            //设置验证的宽度
                           Code::width(450)->height(50)->num(v('config.numb'))->make();
                       }
                       /**
                        * 退出登录
                        */
                       public function out()
                       {
                           //删除所有数据
                           Session::flush();
                           //__ROOT__这里是指转到当前路径
                           go(__ROOT__.'/login');
                           //p(__ROOT__);die;
                       }
                   
                   
            |-- 1.7 Slide.php //轮播图管理控制器
                |-- namespace app\admin\controller;  // 命名空间
                   use houdunwang\request\Request;   // 引入houdunwang\request\Request 的命名空间
                   use system\model\Slide as SlideModel;  //引入 Slide模块的命名空间因为和类同名所以起别名
                   class Slide extends Common { 
                        public function __construct()
                       {
                           //把common里面的验证加载进来
                           $this->auth();
                       }
                       /**
                        * 轮播图首页
                        * @return mixed
                        */
                       public function index(){
                           //此处书写代码...
                           //调用SlideModel表，在里面找到数据并且分页到页面上
                           $field = SlideModel::paginate(2);
                           return view('',compact('field'));
                       }
                       /**
                        * 编辑和添加
                        * @return array|mixed
                        */
                       public function post()
                       {
                           //调用Request方法，获得get里面 slide_id
                           $slide_id = Request::get('slide_id');
                           //如果数据表找不到这条数据的id 说明是添加，如果找到了那么就是编辑
                           $model = SlideModel::find($slide_id) ? :new SlideModel();
                           if (IS_POST)
                           {
                               //调用save方法，把Request获得的post数据，执行添加
                               $model->save(Request::post());
                               //成功的提示，和成功之后跳转的页面
                               return $this->setRedirect('index')->success('操作成功');
                           }
                           //加载模板，并且把存到model里面的变量分配到页面上
                           return view('',compact('model'));
                       }
                       public function remove()
                       {
                           //调用Request方法，获得get参数里面的id
                           $slide_id = Request::get('slide_id');
                           //在slide表中找到这条数据的主键id
                           $model = SlideModel::find($slide_id);
                           //执行删除
                           $model->destory();
                           //成功的提示信息，和要跳转的页面
                           return $this->setRedirect('index')->success('操作成功');
                       }
                   
                   
        |-- 1.8 view //模板文件
            |-- 1.8.1 1article //文章模板目录
            
                |-index //文章首页模板页面
                |-post  //文章添加模板页面
                
            |-- 1.8.2 category //栏目模板目录
                
                |-index  //栏目首页模板页面
                |-post  //栏目添加模板页面
                
            |-- 1.8.3 config //系统模板目录
                
                |-setting  //系统模板页面
                
            |-- 1.8.4 entry //后台登录模板目录
                
                |-changePassword //修改密码模板页面
                |-index //后台登录模板页面
                
            |-- 1.8.5 login //登录模板目录
                
                |-index  //登录首页模板页面

            |-- 1.8.6 slide //轮播图模板目录
                |-index  //轮播图首页模板
                |-post  // 轮播图添加模板
                      
    3.home  //前台展示页面
        |-3.1 controller  //控制器文件
            |-3.1.1 entry  //前台控制器类
                |-namespace app\home\controller;  //命名空间
                  use houdunwang\request\Request;  //引入houdunwang\request\Request的命名空间
                  use system\model\Module;  // 引入Module模块的命名空间
                  use system\model\Article; // 引入Article模块的命名空间
                  use system\model\Category;  // 引入Category模块的命名空间
                  class Entry
                  {
                      //在这里把模板目录声明成属性，直接掉用
                      protected $template;
                      public function __construct()
                      {
                          //调用模板时，调用IS_MOBILE 让他自己匹配是 pc端，还是移动端
                          $this->template = 'template/' . (IS_MOBILE ? 'mobile' : 'web');
                          //var_dump(IS_MOBILE);
                          //定义模板路径常量
                          define(__TEMPLATE__,__ROOT__.'/' . $this->template);
                          //1.运行模块
                          //echo 11;
                          //调用下面的runModule方法，
                          $res = $this->runModule();
                      }
                  
                      /**
                       * 网站首页
                       * @return mixed
                       */
                      public function index()
                      {
                          $headConf = [
                              'title'=>'首页',
                              'css'=>['index'],
                          ];
                          //加载模板，分配变量
                          return view($this->template . '/index.html',compact('headConf'));
                      }
                      /**
                       * 栏目首页
                       */
                      public function category()
                      {
                          $headConf = [
                              'title'=>'列表页',
                              'css'=>['list_article'],
                          ];
                          $cate_id = Request::get('cate_id');
                  
                          $cms_field = Category::find($cate_id);
                  
                          return view($this->template . '/list.html',compact('headConf','cms_field'));
                  
                      }
                      //文章内容页
                      public function content()
                      {
                          //调用Request方法，获得get地址栏的 id
                          $arc_id = Request::get('arc_id');
                          $cms_field = Article::find( $arc_id );
                          $headConf = [
                              'title'=>$cms_field['arc_title'],
                              'css'=>['page'],
                          ];
                          //点击次数自增1
                          Db::table("article")->where('arc_id',$arc_id)->increment('arc_click',1);
                          return view( $this->template . '/content.html' , compact( 'headConf','cms_field' ) );
                      }
                      /**
                       * 运行模块
                       */
                      protected function runModule()
                      {
                          //1.1参考地址
                          //http://cui.datongvip.com/wxcms/index.php?m=pic&action=controller/index/index
                          //调用框架的Request方法，获得get参数里面的m的模块名称
                          $m = Request::get('m');
                          //1.8,为了考虑，如果你数据库没有这个模块，那么addons/不会有这个模块，没必要实例化了
                          $module = Module::where('module_name', $m)->first();
                          //p($m);//pic
                          //1.2。调用Request方法，获得get参数里面的 控制器的名称
                          $action = Request::get('action');
                          //这里以上两个get参数同时存在，我们是为你访问模块
                          //1.3注意：$module,是在后来增加的
                          //在这里判断，模块，控制器，方法，同时存在的时候，执行下面的代码
                          if ($module && $m && $action) {
                              //1.4把action转为数组
                              $info = explode('/', $action);
                              //1.5
                              //$class = "\addons\\" . $m . '\\' . $info[ 0 ] . '\\' . ucfirst( $info[ 1 ] );
                              //1.9对1.5进行修改，系统模块需要去module里面实例化
                              $class = ($module['module_is_system'] == 1 ? 'module' : 'addons') . "\\" . $m . '\\' . $info[0] . '\\' . ucfirst($info[1]);
                              //1.6// php 内置函数 执行class 类 info 方法，第二个参数不传为空
                              die(call_user_func_array([new $class, $info[2]], [])) ;
                          }
                          //1.7 返回 false
                          return false;
                      }

        
        |-3.2  view 模板文件
            |- 3.2.1 entry //文件目录
                |-index  //前台展示页面
                   
    4.system //系统  
        
        |- 4.1 controller  //控制器
            |- 4.1.1 backup  // 上传控制器类
            |- 4.1.2 module  // 系统模块控制器类
            
        |- 4.2 view  // 模板文件
            |- 4.2.1 backup //上传模板文件
                |-index  //数据备份文件首页
                |-message  // 数据备份展示页面
            |- 4.2.2 module  //系统模板文件
                |-design //系统模块添加管理页面
                |-index //系统模块展示首页
     
    5.wechat  // 微信
        |- 5.1 controller  //控制器
            |- 5.1.1 api  // 微信通信控制器类
                |-namespace app\wechat\controller;  // 命名空间
                  use houdunwang\route\Controller;  //引入houdunwang\route\Controller的命名空间
                  use houdunwang\wechat\WeChat;  // 引入houdunwang\wechat\WeChat的命名空间
                  use system\model\Keywords;  // 引入Keywords模块命名空间
                  use system\model\Module;  //引入Module模块命名空间
                  use system\model\Config;  //引入Config模块命名空间
                  /**
                   * 跟微信通讯验证
                   * Class Api
                   * @package app\wechat\controller
                   */
                  class Api extends Controller{
                      public function __construct ()
                      {
                          //验证微信通讯,在与微信通讯验证之前，需要注意：在中间件中进行Config::set('wechat')，这一步动作
                          WeChat::valid();
                      }
                      //这个方法是微信绑定的url地址，填写的是能访问到该方法的路径：http://cui.datongvip.com/wxcms/index.php?s=wechat/api/handler
                  
                      public function handler()
                      {
                          //echo 1;
                          //测试消息发送
                          $instance = WeChat::instance('message');
                          //在config表中回复字段为wechat_system_response值
                          $wechat_system_response = Config::find(1)->wechat_system_response;
                          //将其转为数组格式，提取出来，
                          $wechat_system_response = json_decode($wechat_system_response, true);
                          //判断是否是关注消息
                          if ($instance->isSubscribeEvent())
                          {
                              //向用户回复消息
                              $instance->text($wechat_system_response['welcome']);
                          }
                          //这一步是获取粉丝发来的消息,主要是获取关键词
                          $content = $instance->Content;
                          $this->parseKeywords($content);
                          //增加默认回复，
                          //获取默认回复消息的内容，default_message，如果你的默认回复，正好是一个关键词，那么你在随便输入的时候，回复给粉丝的应该是关键词对应的内容
                          $this->parseKeywords($wechat_system_response['default_message']);
                          //菜单的点击事件
                          //houdunwang/wechat替换
                          $button = WeChat::instance('button');
                          if ($button->isClickEvent()) {
                            //获取消息内容
                            //file_put_contents('./aaa.php',var_export($content));
                            //向用户回复消息
                            /$instance->text("点击了菜单,EventKey: {$instance->EventKey}");
                            $this->parseKeywords($instance->EventKey);
                          }
                          //去除默认消息进行回复给粉丝
                          $instance->text($wechat_system_response['default_message']);
                      }
                      //根据粉丝来进行回复
                      protected function parseKeywords($content)
                      {
                          //找到数据表中，关键词id和消息id对应的那条数据
                          $module = Keywords::where('keywords', $content)->first();
                          if ($module) {
                              $instance = WeChat::instance('message');
                              //如果找到了这条数据
                              //$instance->text('找到了...');die;
                              //这个是测试到目前为止，微信是否正常
                              //这句话的目的，希望看到当前这个模块是不是系统模块
                              $module_is_system = Module::where('module_name', $module['module'])->pluck('module_is_system');
                              //如果$module_is_system 那么就是系统模块，如果不是，那么就是去addons里面找，非系统模块，后面是连接的模块，里的system，Processor文件
                              $class = ($module_is_system == 1 ? 'module' : 'addons') . '\\' . $module['module'] . '\system\Processor';
                              //调用一个回调函数，new一下 class这个类，调用handler方法，后面传进去一个参数，module_id
                              //$instance -> text($class);die;
                              return call_user_func_array([new $class, 'handler'], [$module['module_id']]);
                         }
                      }
                  

            |- 5.2common  //总控制器类 
                |-namespace app\wechat\controller;  //命名空间
                  use houdunwang\route\Controller;  //引入houdunwang\route\Controller的命名空间
                  /**
                   * 总登录验证控制器
                   * Class Common
                   * @package app\wechat\controller
                   */
                  abstract class Common extends Controller
                  {
                      //执行中间件，进行登录验证
                      //final 是最终意思，不允许子类重写auth方法
                      //加上final之后，如果子类出现auth方法，就会报错
                      final public function auth()
                      {
                          Middleware::set('auth');
                      }
                  }      
            |- 5.3 config  // 微信系统控制器类
                |-namespace app\wechat\controller;  //命名空间
                  use houdunwang\request\Request;  //引入houdunwang\route\Request的命名空间
                  use system\model\Config as ConfigModel;  //引入模块Config 的命名空间
                  /**
                   * 微信控制器
                   * Class Config
                   * @package app\wechat\controller
                   */
                  class Config extends Common {
                      public function __construct ()
                      {
                          $this->auth();
                      }
                      //动作
                      public function setting (ConfigModel $configModel )
                      {
                          if ( IS_POST ) {
                              //调用中间件里面的setWexinConfig方法，来获得所有的post数据
                              $configModel->setWeixinConfig( Request::post() );
                              return $this->success( '操作成功' );
                          }
                          //获取数据
                          $model = ConfigModel::find( 1 );
                          $field = $model ? json_decode($model['weixin'],true) : [];
                          return view('',compact('field'));
                      }
                  

            |- 5.3 system  // 微信系统回复控制器类
                |-namespace app\wechat\controller;  //命名空间
                  use houdunwang\request\Request;   // 引入houdunwang\request\Request的命名空间
                  use system\model\Config;  //移入模块Config 的命名空间
                  /**
                   * 微信系统回复
                   * Class System
                   * @package app\wechat\controller
                   */
                  class System extends Common {
                      //动作
                      public function index(){
                          //此处书写代码...
                          //找到config表的存回复消息的数据，如果找不到，那么就new一下这个类，
                          $model = Config::find(1) ? : new Config();
                          if(IS_POST)
                          {
                              //这里调用Request获取post所有的数据，存到$post里面，
                              $post = Request::post();
                              //找到config，把接受到的回复消息的那条数据，存到表中，注意得转成 josn形式，字符串存进去，加JSON_UNESCAPED_UNICODE，不要系统编码，
                              $model->wechat_system_response = json_encode($post,JSON_UNESCAPED_UNICODE);
                              //调用save方法，执行添加
                              $model->save();
                              //成功的提示消息，调用setRedirect方法，让他刷新页面，
                              return $this->setRedirect('refresh')->success('操作成功');
                          }
                          //把存到 config表里面，wechat_system_response这个字段里的消息，拿出来，json_decode转为数组，存到field里面。
                          $field = json_decode($model['wechat_system_response'],true);
                          //加载页面，并且分配存到 field中的变量
                          return view('',compact('field'));
                      }


        |-5.4 view   // 模板
        
            |-5.4.1 config // 微信配置模板
                |-setting  //微信配置模板首页
            |- 5.4.2 system  //系统配置模板
                |-index  // 系统回复模板首页
                
   
>module  //系统模块目录
    
    |-7.1 article   // 系统回复消息目录
    
        |- 7.1.1 syetem  //系统模板文件
            |-processor //回复消息的控制器
                |-namespace module\article\system;  // 命名空间
                  use module\Hdprocessor;   //引入module\Hdprocessor 的命名空间
                  use system\model\Article;  //引入模块 Article 的命名空间
                  
                  class Processor extends Hdprocessor
                  {
                      /**
                       * @param $module_id   指的是关键词表module_id,同时还是文章主键id
                       */
                  	public function handler($module_id)
                  	{
                  	    //在这里测试，微信通讯是否还是正常的
                          //$this->text('hh');
                          //在这里根据module_id然后在文章表中找对应的数据
                          $data = Article::find($module_id);
                          //这里是向用户回复图文消息
                          $news=array(
                              array(
                                  'title'=>$data['arc_title'],
                                  'discription'=>$data['arc_description'],
                                  'picurl'=>__ROOT__.'/'.$data['arc_thumb'],
                                  'url'=>__ROOT__."/{$data['arc_id']}.html"
                              ),
                          );
                          $this->news($news);
                      }
        
    |-7.2 base   //  系统模块目录
    
        |-7.2.1 controller  // 控制器
            |-wx  //微信回复控制器
                |-namespace module\base\controller;  //命名空间
                  use houdunwang\request\Request;   // 引入houdunwang\request\Request的命名空间
                  use module\base\model\BaseContent;  // 填入模块model 的命名空间，因为和类同名所以必须起别名
                  use module\HdController;   //引入系统模块的HdController的命名空间
                  class Wx extends HdController
                  {
                      public function index()
                      {
                          //获得数据库所有数据，每页显示2条，
                          $field = BaseContent::paginate( 2 );
                          //?m=base&action=controller/wx/index
                          //echo url('wx.index');die;
                          ////http://cui.datongvip.com/wxcms?m=base&action=controller/wx/index
                          return $this->template('',compact('field'));
                      }
                      //添加回复
                      public function post()
                      {
                          //接受get参数id，是baseContent表主键，就我们要编辑数据编号
                          $id        = Request::get( 'id' );
                          //如果有这个id，就是编辑(找出这条数据),没有这个id，就是添加(新实例出一个模型)
                          $baseModel = BaseContent::find( $id ) ? : new BaseContent();
                          //判断，
                          if (IS_POST) {
                              //调用 Request 方法，来获取所有的post数据
                              $post = Request::post();
                              //把存进去的数据，用save的方法，里面的传参数，分配出去。
                              $baseModel->save($post);
                              //查看关键词里面的id 和 消息回复里面的 id 他们的值，是否相等
                              //var_dump($baseModel['module_id']);
                              $post['module_id'] = $baseModel['id'];
                              //实例化 调用 wechat 里面的的 saveKeywords 方法，
                              $this->saveKeywords($post);
                              //成功的提示信息，和跳转地址，url 是我们自己定义的跳转的方法
                              return $this->setRedirect(url('wx.index'))->success('操作成功');
                          }
                          //调用Wechat类中assignKeywords(base_content表的主键)
                          $this->assignKeywords($id);
                          //把存进去的数据，分配出去
                          return $this->template('',compact('baseModel'));
                      }
                      //删除模块
                      public function del()
                      {
                          //接受get参数id，是baseContent表主键，就我们要编辑数据编号
                          $id = Request::get('id');
                          //p($id);die;
                          //找到回复的内容那条数据ID执行删除
                          $model = BaseContent::find($id);
                          $model->destory();
                          //删除关键词
                          $this->delKeywords($id);
                          //成功提示
                          return $this->setRedirect(url('wx.index'))->success('操作成功');
                      }
                  
                  
        |-7.3 model   //模块表目录
             
        |-7.4 system   //系统回复目录
            |-7.4.1 processor //系统回复的控制器
                |-namespace module\base\system;  //命名空间
                  use houdunwang\wechat\WeChat;  //引入houdunwang\wechat\WeChat的命名空间
                  use module\base\model\BaseContent;  //引入系统目录中的系统base模块中的basecontent表的命名空间
                  use module\Hdprocessor;  //引入系统模块中的Hdprocessor的命名空间
                  class Processor extends Hdprocessor
                  {
                  	public function handler($id)
                  	{
                  		$instance = WeChat::instance('message');
                  		//$instance->text('你好，18年的坚持。。。');
                          //找到回复消息表中的消息的id
                          $base = BaseContent::find($id);
                          //发送关键词，回复他里面的content内容
                          $instance->text($base['content']);
                  	}
                  
                  
        |-7.5 templase   //模板目录
            |- 7.5.1 wx 微信菜单目录模板
                |-index  //菜单展示模板
                |-post  //菜单添加模板
                
                
    |-7.6 button   //   菜单目录
        |- 7.6.1 controller   //微信菜单控制器
            |-button  //菜单控制器、
                |-namespace module\button\controller;   //命名空间
                  use houdunwang\request\Request;   //引入houdunwang\request\Request方法的命名空间
                  use module\HdController;    //  引入系统模块中的HdController控制器的命名空间
                  use system\model\Button as ButtonModel;   //引入模块Button的命名空间
                  use houdunwang\wechat\WeChat;   //引入houdunwang\wechat\WeChat的命名空间
                  class Button extends HdController   
                  {
                  	public function index ()
                  	{
                  	    //echo 1;die;
                          //在button表中获得get的所有数据
                  		$field = ButtonModel::get();
                  		//加载模板首页 并且把获得的所有数据分配出去，
                  		return $this->template('',compact('field'));
                  	}
                  	//添加回复
                  	public function post ()
                  	{
                  	    // 调用Request方法，获得get的所有数据
                  		$id = Request::get('id');
                  		//在button表中找到那条数据的主键id，如果找不到，那就new一下这个button表
                  		$model = ButtonModel::find($id) ? : new ButtonModel();
                  		if(IS_POST)
                  		{
                  			//p($_POST);die;
                              //调用Request方法，获得post提交来的所有数据
                  			$post = Request::post();
                  			if($id){
                  			    //如果state == 0 那么说明数据库没有数据，这里就是添加
                  				$post['state'] = 0;
                  			}
                  			//把获得存到$model的数据，调用save方法 进行添加
                  			$model->save($post);
                  			//成功的提示，和跳转的地址
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
                          // 调用Request方法，获得get的所有数据
                          $id = Request::get('id');
                  		//p($id);die;
                  		//删除回复内容
                          //在button表中找到 要删除的那条数据的主键id
                  		$model = ButtonModel::find($id);
                  		//调用destory方法执行删除
                  		$model->destory();
                  		//成功提示，和跳转的地址
                  		return $this->setRedirect(url('button.index'))->success('操作成功');
                  	}
                  	//菜单推送
                      public function send()
                      {
                          //接受get参数
                          $id = Request::get('id');
                          //根据id在数据库中对应的数据
                          $data = ButtonModel::find($id)->content;
                          $button['button'] = json_decode($data, true);
                          //p($button);die;
                          //菜单数据推送给微信
                          //是否使用的是测试账号，appid和appsecret是不是为测试账号参数
                          $res = WeChat::instance('button')->create($button);
                          if ($res['errcode'] == 0) {
                              //代表推送成功
                              //进行状态修改
                              Db::table('button')->where("id", $id)->update(['state' => 1]);
                              //把其他的菜单状态修改为0
                              Db::table('button')->where("id", '<>', $id)->update(['state' => 0]);
                              return $this->setRedirect(url('button.index'))->success('菜单推送成功');
                          } else {
                              return $this->error('错误码：' . $res['errcode'] . '；错误消息' . $res['errmsg']);
                          }
                      }
                  
    
        |- 7.7 system   //微信菜单管理
            |- 7.7.1 processor  // 微信菜单管理控制器
                
        |-7.8 template  //微信菜单模板
            |- 7.8.1 button  //菜单模板
                |-index  //菜单模板首页
                |-post   //菜单模板添加页面
        
    
    |-7.9 HdController  //系统控制器
        |-namespace module;   //命名空间
          use houdunwang\request\Request;   //引入houdunwang\request\Request方法的命名空间
          use houdunwang\route\Controller;   //引入houdunwang\route\Controller方法的命名空间
          use system\model\Module;   //引入模块Module的命名空间
          class HdController extends Controller
          {
              use Wechat;
              //把模板文件声明成属性
              protected $template;
              public function __construct()
              {
                  //调用框架里面的Request 方法，来获得 get参数，m里面的模块
                  $m = Request::get('m');
                  //根据地址栏m参数，查出来结果中module_is_system知道是不是系统模块
                  $module = Module::where( 'module_name' , $m )->first();
                  //调用template 这个属性，如果$module 里面的module_is_system ==1，那么就是系统模块，如果不是，那么就用addons里面的模块，
                  $this->template = ( $module[ 'module_is_system' ] == 1 ? 'module' : 'addons' ) . '/' . $m . '/template/';
              }
              //加载模板 、这里定义一个空值
              protected function template($tpl = '',$args = [])
              {
                  //把Request获得get参数里面的 控制器，转为数组，存到info里面
                  $info = explode('/',Request::get('action'));
                  //如果你传了模板那么就加载你的模板，如果没传，那么加载系统默认的。
                  $tpl = empty($tpl) ? $info[2] : $tpl;
                  //info[1]控制器类，$info[ 2 ]指得是方法
                  //echo $this->template . strtolower( $info[ 1 ] ) . '/' . $tpl;die;
                  //加载模板，调用tomplate 方法，把模板首字母全部转为小写，连接上 / 和方法名
                  return view( $this->template . strtolower( $info[ 1 ] ) . '/' . $tpl ,$args);
              }
          
          

    |-7.10 Hdprocessor   //系统处理器
        |-namespace module;   //命名空间
          use houdunwang\wechat\WeChat;   //引入houdunwang\wechat\WeChat的命名空间
          class Hdprocessor
          {
              /**
               * 魔术方法，调用一个未找到的方法时候，会自动触发
               * @param $name       未找到的方法名称
               * @param $arguments
               */
              public function __call($name, $arguments)
              {
                  // TODO: Implement __call() method.
                  $instance = WeChat::instance('message');
                  //测试，给微信回复消息，常看通讯是否还连接上
                  //$instance->text( 'bbbb' );
                  //调用一个 回调函数，new一下$instance 这个类，把未找到的方法名称穿进去，在把要的内用因为打印的是一维数组，我们调用current，只有数组里面的内容。
                  return call_user_func_array( [ new $instance , $name ] , [  current($arguments) ] );
              }
          
          
    |-7.11 Wechat   //微信基本回复控制器
        |-namespace module;   //命名空间
          use houdunwang\request\Request;   //引入houdunwang\wechat\WeChat的命名空间
          use system\model\Keywords;   // 引入模块Keywords的命名空间
          trait Wechat
          {
              //添加基本回复
              final protected function saveKeywords($data)
              {
                  //在这里检测 $data['module'] 是否存在，如果存在，呢就用传进来的，如果不存在 就用获得get里面的模块
                  $module = isset($data['module']) ? $data['module'] : Request::get('m');
                  //这里把需要的条件都提出来，传个参数进去，这样更加简洁。
                  $where = [
                      ['module_id',$data['module_id']],
                      ['module',$module]
                  ];
                  $keyWordsModel = Keywords::where($where)->first() ? : new Keywords();
                  $data['module'] = $module;
                  //把data里面的数据，执行save添加
                  $keyWordsModel->save($data);
              }
              /**
               * 分配关键词变量
               * @param $modeu_id
               * 关键词表module_id，也就是对应baseContent表中主键id
               */
              final protected function assignKeywords($module_id)
              {
                  //这里把需要的条件都提出来，传个参数进去，
                  $where = [
                      ['module_id',$module_id],
                      ['module',Request::get('m')]
                  ];
                  //如果找到这条数据，说明where条件都成立，然后执行下面代码，如果找不到，就实例化
                  $keyWordsModel = Keywords::where($where)->first() ? : new Keywords();
                  //分配
                  View::with('keywords',$keyWordsModel['keywords']);
              }
              /**
               * 删除关键词
               */
              final protected function delKeywords($module_id)
              {
                  //这里把需要的条件都提出来，传个参数进去，这样更加简洁。
                  $where = [
                      ['module_id',$module_id],
                      ['module',Request::get('m')]
                  ];
                  //如果找到这条数据表where条件都对应的那条数据，那么久执行下面代码，如果找不到，那么实例化这个表。
                  $keyWordsModel = Keywords::where($where)->first() ? : new Keywords();
                  //代码运行到这里说明找到这个数据的关键词了，执行删除。
                  $keyWordsModel->destory();
              }
          
  
>resource   //资源文件夹

    |-8.1 admin  //父级模板文件
    |-8.2 images  //图片文件夹
    |-8.3 view   //视图文件
   
>storage   //系统缓存目录

    |-9.1 session   //SESSION目录
    |-9.2 view     // 视图缓存目录

>template  // 模板目录

    |-14.1 mobile    //pc端模板目录
    |-14.2 web    //电脑端模板目录











