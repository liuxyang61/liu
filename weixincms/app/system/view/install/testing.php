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
                    <li class=""><a href="#">框架手册</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
        <div class="col-sm-3">
            <ul class="list-group">
                <li class="list-group-item ">版权信息</li>
                <li class="list-group-item active">环境检测</li>
                <li class="list-group-item">初始数据</li>
                <li class="list-group-item">安装完成</li>
            </ul>
        </div>
        <div class="col-sm-9">

            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">系统环境</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>运行环境</td>
                                <td>{{$data['server_software']}}</td>
                            </tr>
                            <tr>
                                <td>php版本</td>
                                <td>{{$data['php_version']}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">环境检测</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>php版本</td>
                                <td>
                                    <?php if(version_compare('7.1.2','5.6','>')){ ?>
                                        <i class="fa fa-check-circle alert-success"></i>
                                    <?php }else{ ?>
                                        <i class="fa fa-times-circle hd-error"></i>
                                    <?php } ?>

                                </td>
                            </tr>
                            <tr>
                                <td>pdo</td>
                                <td>
                                    <if value="$data['pdo']">
                                        <i class="fa fa-check-circle alert-success"></i>
                                        <else/>
                                        <i class="fa fa-times-circle hd-error"></i>
                                    </if>

                                </td>
                            </tr>
                            <tr>
                                <td>gd</td>
                                <td>
                                    <if value="$data['gd']">
                                        <i class="fa fa-check-circle alert-success"></i>
                                        <else/>
                                        <i class="fa fa-times-circle hd-error"></i>
                                    </if>
                                </td>
                            </tr>
                            <tr>
                                <td>curl</td>
                                <td>
                                    <if value="$data['curl']">
                                        <i class="fa fa-check-circle alert-success"></i>
                                        <else/>
                                        <i class="fa fa-times-circle hd-error"></i>
                                    </if>
                                </td>
                            </tr>
                            <tr>
                                <td>openssl</td>
                                <td>
                                    <if value="$data['openssl']">
                                        <i class="fa fa-check-circle alert-success"></i>
                                        <else/>
                                        <i class="fa fa-times-circle hd-error"></i>
                                    </if>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{{u('copyright')}}"  class="btn btn-primary">上一步</a>
                <a href="javascript:;" onclick="nextStep()" class="btn btn-success">下一步</a>
            </div>

        </div>
    </div>
</div>



<script>
    function nextStep() {
        require(['jquery','util'],function($,util){
            if($('.hd-error').length>0){
                util.message('环境不符合安装要求','','error');
            }else{
                location.href = "{{u('database')}}";
            }
        })
    }
</script>
</body>
</html>