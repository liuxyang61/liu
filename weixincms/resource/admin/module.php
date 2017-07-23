
<!DOCTYPE html>
<html lang="en">
<!--头部开始-->
<head>
    <meta charset="utf-8"/>
    <title>{{v('config.webname')}}</title>
    <meta name="csrf-token" content="">
    <!--    <scritp src="resource/org/angular.min.js"></scritp>-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <!--    <link href="http://dev.hdcms.com/node_modules/hdjs/css/bootstrap.min.css" rel="stylesheet">-->
    <script>
        //模块配置项
        var hdjs = {
            //框架目录
            'base': '{{__ROOT__}}/node_modules/hdjs',
            //上传文件后台地址
            'uploader': "{{u('component.Upload.uploader')}}",
            //获取文件列表的后台地址
            'filesLists':" {{u('component.Upload.filesLists')}}",
        };
    </script>
    <script src="{{__ROOT__}}/node_modules/hdjs/app/util.js"></script>
    <script src="{{__ROOT__}}/node_modules/hdjs/require.js"></script>
    <script src="{{__ROOT__}}/node_modules/hdjs/config.js"></script>
    <!--    <script src="http://dev.hdcms.com/resource/js/hdcms.js"></script>-->
    <link href="{{__ROOT__}}/resource/css/hdcms.css" rel="stylesheet">
    <link href="{{__ROOT__}}/node_modules/hdjs/css/font-awesome.css" rel="stylesheet">
    <script>
        require(['jquery'], function ($) {
            //为异步请求设置CSRF令牌
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
        if (navigator.appName == 'Microsoft Internet Explorer') {
            if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
                alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
            }
        }
    </script>
</head>
<!--头部结束-->
<!--body内容-->
<body class="site">
<div class="container-fluid admin-top">
    <!--导航-->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <ul class="nav navbar-nav">

                    <li>
                        <a href="{{__ROOT__}}">
                            <i class="fa fa-reply-all"></i> 返回系统
                        </a>
                    </li>

                    <li class="top_menu">
                        <a href="{{u('admin.category.index')}}">
                            <i class="'fa-w fa fa-cubes"></i> 文章系统                        </a>
                    </li>
                    <li class="top_menu ">
                        <a href="{{u('wechat.weixin.index')}}">
                            <i class="'fa-w fa fa-comments-o"></i> 微信功能                        </a>
                    </li>

                    <li class="top_menu ">

                        <a href="{{u('system.config.index')}}">
                            <i class="'fa-w fa fa-gears"></i> 系统功能                     </a>
                    </li>
                    <li class="top_menu active">

                        <a href="{{u('system.module.index')}}">
                            <i class="'fa-w fa fa-arrows"></i> 模块功能                     </a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">


                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="fa fa-w fa-user"></i>
                            admin                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="?s=admin/login/setPassword">修改密码</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{u('admin.login.out')}}">退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--导航end-->
</div>
<!--主体-->
<div class="container-fluid admin_menu">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-lg-2 left-menu">
            <div class="search-menu">
                <input class="form-control input-lg" type="text" placeholder="输入菜单名称可快速查找"
                       onkeyup="search(this)">
            </div>
            <!--扩展模块动作 start-->
            <div class="panel panel-default">

                <!--                设计模块-->
                <div class="panel-heading">
                    <h4 class="panel-title">设计模块</h4>
                    <a class="panel-collapse" data-toggle="collapse" href="javascript:;">
                        <i class="fa fa-chevron-circle-down"></i>
                    </a>
                </div>
                <ul class="list-group menus">
                    <li class="list-group-item" id="86">
                        <a href="{{u('system.module.index')}}">模块列表</a>
                    </li>
                    <li class="list-group-item" id="86">
                        <a href="{{u('system.module.design')}}">设计模块</a>
                    </li>
                </ul>

<!--                插件管理-->


                <if value="$moduleData" >
                <div class="panel-heading">
                    <h4 class="panel-title">插件管理</h4>
                    <a class="panel-collapse" data-toggle="collapse" href="javascript:;">
                        <i class="fa fa-chevron-circle-down"></i>
                    </a>
                </div>
                </if>
                <ul class="list-group menus">
                    <foreach from="$moduleData" value="$v">
                    <li class="list-group-item" id="86">
                        <a href="{{url('admin.index',$v['module_name'])}}">{{$v['module_title']}}</a>
                    </li>
                </foreach>
                </ul>

                <if value="Request::get('m')">
                    <div class="panel-heading">
                        <h4 class="panel-title">当前插件</h4>
                        <a class="panel-collapse" data-toggle="collapse" href="javascript:;">
                            <i class="fa fa-chevron-circle-down"></i>
                        </a>
                    </div>
                    <ul class="list-group menus">
                        <blade name="modulename"/>
                    </ul>
                </if>

                <!----------返回模块列表 start------------>
                <!--模块列表-->
                <!--模块列表 end-->
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-lg-10">
            <!--有模块管理时显示的面包屑导航-->
            <blade name="content"/>
        </div>
    </div>
</div>
<!--主体结束-->
<!--底部网站信息-->
<div class="master-footer" >
    <a href="http://www.houdunwang.com">猎人训练</a>
    <a href="http://www.hdphp.com">开源框架</a>
    <a href="http://bbs.houdunwang.com">后盾论坛</a>
    <br>
    站长邮箱:{{v('config.email')}}  | 联系电话:{{v('config.tel')}}
    <br>
    京ICP号: <a href="javascript:;"> {{v('config.icp')}}</a>
</div>
<!--底部网站信息结束-->
<!--加载js,应用函数-->
<script src="http://dev.hdcms.com/resource/js/menu.js"></script>
<script src="http://dev.hdcms.com/resource/js/quick_navigate.js"></script>
<script>
    require(['bootstrap','angular']);
</script>
<!--加载js和应用函数结束-->
</body>
<!--body内容结束-->
</html>
<!--css样式-->
<style>
    table{
        table-layout: fixed;
    }
</style>