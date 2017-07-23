<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>刘阳个人博客</title>
    <!-- BOOTSTRAP CORE STYLE -->
    <link href="{{__TEMPLATE__}}/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICON STYLE -->
    <link href="{{__TEMPLATE__}}/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href="{{__TEMPLATE__}}/assets/css/Style.css" rel="stylesheet" />
</head>
<body>
<!--头部-->
<div id="header" >
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col-md-4 logo-div">
                    <div class="logo-inner text-center">
                        <div class="logo-name">
                            <a href="{{__ROOT__}}" title="点击跳转首页">
                                <!--首页博主头像-->
                                <img src="{{__TEMPLATE__}}/assets/img/me.jpg" class="img-circle" />
                            </a>
                        </div>

                    </div>

                </div>
                <div class="col-md-8 header-text-top " id="about">
                    <h1>刘阳个人博客首页</h1>
                    欢迎来到刘阳个人博客首页，这里有我的创作项目,和我日常的日志。
                    <br>
                    本博客页面使用引导程序和HTML创建了一个非常好的博客页面，响应性很强.希望您能喜欢。
                    <br />
                    <br />
                    <!--<h2><strong>Who I am ? </strong></h2>-->
                    <!--<i>I am Jhon Deo </i>-->
                    <!---->
                </div>
            </div>
        </div>
    </div>
</div>
<!--头部结束-->
<!--END HEADER SECTION-->
<!--联系邮箱-->
<div class="info-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                联系博主 ： <strong>liu759831874</strong>@sina.com
            </div>
            <div class="col-md-2">
                <div class="social-link">
                </div>

            </div>

        </div>
    </div>
</div>
<!--联系邮箱结束-->

<!--END INFO SECTION-->

<div class="container">
    <!--中间主体部分-->
    <div class="row" >



        <!--真正的需要更换的部分-->
        <!--自定义了一个栏目导航,搜索框-->
        <div class="alert" >
            <div class="input-group col-sm-6" style="float: left;left:0px;">
                当前搜索标题：
                <a id="index"  href="{{__ROOT__}}"  style="color: black; text-decoration: none">{{$data[0]['search_name']}}</a>
                <!--<span  id="index" style="display:inline-block;border: 1px solid red; color: #7E86B6;width: 100px; overflow: hidden;-->
                <!--text-overflow: ellipsis;-o-text-overflow: ellipsis;white-space:nowrap;">{{$categoryData['cate_name']}}</span>-->
                <span   style=" color: #0b1418;width: 100px;">{{$categoryData['cate_name']}}</span>
            </div>
            <form action="{{url('admin.search','search')}}" method="POST" role="form">
                <div class="input-group col-sm-3" style="float: right;right: -6px;">
                    <input style="width: 78%;" type="text" class="form-control" name="search_name" placeholder="请输入搜索">
                    <button style="width:20%;height:34px;" type="submit" class="input-group-addon">搜索</button>
                </div>
            </form>
        </div>
        <!--左侧文章部分-->



        <div class="col-md-8 ">

            <if value="$data[0]['arc_title']">
            <!--获取对应栏目所有文章数据-->
            <div class="blog-post" >
                <!--标题-->
                <foreach from="$data" value="$value">
                    <span></span><a id="arc_title" href="{{__ROOT__}}/{{$value['arc_id']}}.html">{{$value['arc_title']}}</a>
                    <!--作者-->
                    <span>作者: {{$value['arc_author']}}</span>
                    <!--发布时间-->
                    <span style="float:right;">发布时间：{{$value['created_at']}} </span>
                    <!--文章内容                   -->
                    <p style="font-size: 16px;">{{$value['arc_description']}}</p>
                    <a href="{{__ROOT__}}/{{$value['arc_id']}}.html" class="btn btn-default btn-sx ">阅读更多<i class="fa fa-angle-right"></i></a>
                </foreach>
            </div>
                <else/>
                <p>暂时无查询结果：文章未找到</p>
        </if>
            <br />
            <nav>
<!--                {{$page}}-->
            </nav>
        </div>



        <!--这个是中间分离的div-->
        <div class="col-md-1"></div>

        <!--右侧栏目部分-->
        <div class="col-md-3" style="padding-top: 30px;">
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item"><strong>栏目分类</strong></li>
                    <category>
                        <li class="list-group-item"><a class="category" href="{{__ROOT__}}/c/{{$v[cate_id]}}.html">{{$v['cate_name']}}</a></li>
                    </category>
                </ul>
            </div>
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item"><strong>友情链接</strong></li>
                    <tag action="links.links" row="6" >
                        <li class="list-group-item"><a target="_blank" class="category" href="{{$v['links_url']}}">{{$v['links_name']}}</a>
                        </li>
                    </tag>
                </ul>
            </div>
            <div class="row" style="border: 1px solid #DDDDDD;height: 300px;">
                <h3 style="text-align: center">广告</h3>
                <img src="" alt="">
            </div>
        </div>
        <!--右侧栏目部分结束-->
    </div>
    <!--主体部分结束-->

</div>




<!--底部部分-->
<!--END HOME PAGE SECTION-->
<div class="footer-sec" style="margin-top: 0px;">
    <div class="container">
        <div class="row" style="color: white;width: 100%;height: 100px;padding-top: 10px">

            <!--上部分-->
            <p style="text-align: center;color: white;">

                {{v('config.webname')}}版权所有
                &nbsp;&nbsp;
                Call Me  :  {{v('config.tel')}}(北京)
                &nbsp;&nbsp;
                email : {{v('config.email')}}
                &nbsp;&nbsp;

                <!--下部分图标-->


                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=759831874&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:759831874:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>
                <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1262377066'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1262377066%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
            </p>
            <p style="font-size: 12px;line-height: 1.5em;width: 100%;text-align: center;">Copyright © 1996- 2017 Mr.liu All Rights Reserved
                <br>
                <a style="font-size: 12px;line-height: 1.5em;" href="javascript:;">{{v('config.icp')}}</a>
            </p>
        </div>
    </div>
</div>
<!--底部部分结束-->
<!-- END FOOTER SECTION -->

<!--JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME -->
<!-- CORE JQUERY -->
<script src="{{__TEMPLATE__}}/assets/js/jquery-1.11.1.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="{{__TEMPLATE__}}/assets/js/bootstrap.js"></script>

</body>
</html>
