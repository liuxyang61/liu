<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>系统安装</title>
    <script>
        //模块配置项
        var hdjs = {
            //框架目录
            'base': '{{__ROOT__}}/node_modules/hdjs',
            //上传文件后台地址
            'uploader': "{{u('component.upload.uploader')}}",
            //获取文件列表的后台地址
            'filesLists': "{{u('component.upload.filesLists')}}",
        };
    </script>
    <link href="{{__ROOT__}}/node_modules/hdjs/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{__ROOT__}}/node_modules/hdjs/css/font-awesome.min.css" rel="stylesheet">
    <script src="{{__ROOT__}}/node_modules/hdjs/app/util.js"></script>
    <script src="{{__ROOT__}}/node_modules/hdjs/require.js"></script>
    <script src="{{__ROOT__}}/node_modules/hdjs/config.js"></script>
    <link href="{{__ROOT__}}/resource/css/hdcms.css" rel="stylesheet">
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
<body>
<div class="container">
    <div class="row">
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">HDCMS</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class=""><a href="#">后盾人 人人做后盾</a></li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </nav>
        <div class="col-sm-3">
            <ul class="list-group">
                <li class="list-group-item ">版权信息</li>
                <li class="list-group-item ">环境检测</li>
                <li class="list-group-item active">初始数据</li>
                <li class="list-group-item">安装完成</li>
            </ul>
        </div>
        <div class="col-sm-9">
            <form action="" method="POST" class="form-horizontal" role="form" onsubmit="return post(event)">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">连接数据库配置</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">主机</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="host" value="127.0.0.1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">数据库的帐号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user" value="cms">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">数据库的密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" value="cms123">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">数据库</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="database" value="cms">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">表前缀</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="prefix" value="weixincms_">
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{u('testing')}}"  class="btn btn-primary">上一步</a>
                <button  class="btn btn-success">下一步</button>

            </form>

        </div>
    </div>
</div>
<script>
    function post(event) {
        //阻止表单默认行为
        event.preventDefault();
        require(['util'], function (util) {
            util.submit({
                successUrl:"{{u('tables')}}",
            });
        });
    }
</script>
</body>
</html>