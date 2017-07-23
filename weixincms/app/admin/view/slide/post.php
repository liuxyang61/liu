<extend file='resource/admin/base'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li ><a href="{{u('index')}}">轮播图列表</a></li>
        <li class="active"><a href="{{u('post')}}" >{{$model['slide_id']?'轮播图编辑':'轮播图添加'}}</a></li>
    </ul>
    <!-- TAB CONTENT -->
        <form action="" method="POST" class="form-horizontal" role="form" onsubmit="return post(event)">
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title">轮播图管理</h3>
            	  </div>
            	  <div class="panel-body">
<!--                      轮播图标题-->
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">轮播图标题</label>
                          <div class="col-sm-10">
                              <input type="text"  name="slide_title" value="{{ $model['slide_title']}}" class="form-control" >
                          </div>
                      </div>


                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">排序</label>
                          <div class="col-sm-10">

                              <input type="text" name="slide_orderby" value="{{$model['slide_orderby']}}" class="form-control" id="" placeholder="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">外部链接</label>
                          <div class="col-sm-10">
                              <input type="text"  name="slide_url" value="{{$model['slide_url']}}" class="form-control" id="" placeholder="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">文章缩略图</label>
                          <div class="col-sm-10">
                              <div class="input-group">
                                  <input type="text" class="form-control" name="slide_thumb" readonly="" value="{{$model['slide_thumb']}}">
                                  <div class="input-group-btn">
                                      <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
                                  </div>
                              </div>
                              <div class="input-group" style="margin-top:5px;">
                                  <img src="{{pic($model['slide_thumb'],'resource/images/nopic.jpg')}}" class="img-responsive img-thumbnail" width="150">
                                  <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
                              </div>
                          </div>
                      </div>



                      <button type="submit" class="btn btn-primary">确定</button>

                  </div>
            </div>
        </form>
    <script>
        function post(event) {
            //阻止表单默认行为
            event.preventDefault();
            require(['util'], function (util) {
                util.submit({
                    successUrl:"{{u('index')}}",
                });
            });
        }
    </script>
    <script>
        //上传图片
        function upImage(obj) {
            require(['util'], function (util) {
                options = {
                    multiple: false,//是否允许多图上传
                    //data是向后台服务器提交的POST数据
                    data:{name:'后盾人',year:2099},
                };
                util.image(function (images) {          //上传成功的图片，数组类型

                    $("[name='slide_thumb']").val(images[0]);
                    $(".img-thumbnail").attr('src', images[0]);
                }, options)
            });
        }

        //移除图片
        function removeImg(obj) {
            $(obj).prev('img').attr('src', 'resource/images/nopic.jpg');
            $(obj).parent().prev().find('input').val('');
        }
    </script>

</block>


