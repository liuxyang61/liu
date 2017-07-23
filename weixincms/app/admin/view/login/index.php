<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>HDCMS开源免费-微信/桌面/移动三网通CMS系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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
        if (navigator.appName == 'Microsoft Internet Explorer') {
            if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
                alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
            }
        }
    </script>
</head>
<body class="login" style="background: url('/resource/images/sky.jpg')repeat;">
<div class="container logo">
    <div style="background: url('http://dev.hdcms.com/resource/images/logo.png') no-repeat; background-size: contain;height: 60px;"></div>
</div>
<div class="container well" style="box-shadow: 0px 0px 0px #dddddd;">
    <div class="row ">
        <div class="col-md-6">
            <!--            <form method="post" action="" onsubmit="return login(this)">-->
            <form method="post" action="" onsubmit="return post(event)">
                <input type='hidden' name='csrf_token' value=''/>
                <div class="form-group">
                    <label>帐号</label>

                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-w fa-user"></i></div>
                        <input type="text" name="admin_username" class="form-control input-lg"
                               placeholder="请输入帐号">
                    </div>
                </div>
                <div class="form-group">
                    <label>密码</label>

                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-w fa-key"></i></div>
                        <input type="password" name="admin_password"
                               class="form-control input-lg" placeholder="请输入密码">
                    </div>
                </div>
                <div class="form-group">
                    <label>验证码</label>
                    <img src="{{u('admin.login.code')}}" onclick="this.src=this.src+'&rand='+Math.random()" alt="">

                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-w fa-hand-o-right"></i></div>
                        <input type="type" name="code"
                               class="form-control input-lg" placeholder="请输入验证码">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-lg">登录</button>
            </form>
        </div>
        <div class="col-md-6">
            <div style="background: url(/resource/images/2.jpg);background-size:100% ;height:260px;margin-top: 30px;"></div>
        </div>
    </div>
    <div class="copyright">
        Powered by hdcms v2.0 © 2014-2019 www.hdcms.com
    </div>
</div>
<script>
    require(['jquery']);
</script>
<script>
        function login(obj) {
    //        $.post('请求地址',请求数据，function(res){
    //
    //        },'json')
            //获取表单所有数据
            var data = $(obj).serialize();//序列化获取表单数据
            //alert(data);
            $.post("{{u('admin.login.index')}}", data, function (res) {
                //console.log(res)
                if (res.valid) {
                    //执行成功
                    require(['util'], function (util) {
                        util.message(res.message, "{{u('admin.entry.index')}}", 'success');
                    })
                } else {
                    //执行失败
                    require(['util'], function (util) {

                        util.message(res.message, "", 'error');
                    })
                }
            }, 'json')
            //阻止表单刷新
            return false;
        }
</script>
<script>
    function post(event) {
        //阻止表单默认行为
        event.preventDefault();
        require(['util'], function (util) {
            util.submit({
                successUrl:"{{u('admin.entry.index')}}",
            });
        });
    }
</script>
</body>
</html>