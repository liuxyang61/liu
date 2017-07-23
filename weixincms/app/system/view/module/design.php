<extend file='resource/admin/module'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li ><a href="{{u('index')}}">模块列表</a></li>
        <li class="active"><a href="{{u('design')}}" >设计模块</a></li>
    </ul>
    <!-- TAB CONTENT -->
        <form action="" method="POST" class="form-horizontal" role="form" onsubmit="return post(event)">
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title">模块管理</h3>
            	  </div>
            	  <div class="panel-body">
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">模块中文名称</label>
                          <div class="col-sm-10">
                              <input type="text" name="module_title" value="" class="form-control" placeholder="请输入模块中文名称">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">模块标识</label>
                          <div class="col-sm-10">
                              <input type="text" name="module_name" value="" class="form-control" id="" placeholder="请输入模块英文标识">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">模块作者</label>
                          <div class="col-sm-10">
                              <input type="text" name="module_author" value="" class="form-control" id="" placeholder="请输入模块作者">
                          </div>
                      </div>


                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">缩略图</label>
                          <div class="col-sm-10">
                              <div class="input-group">
                                  <input type="text" class="form-control" name="module_thumb" readonly="" value="">
                                  <div class="input-group-btn">
                                      <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
                                  </div>
                              </div>
                              <div class="input-group" style="margin-top:5px;">
                                  <img src="resource/images/nopic.jpg" class="img-responsive img-thumbnail" width="150">
                                  <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">是否处理微信消息</label>
                          <div class="col-sm-10">
                              <div class="checkbox">
                              	<label>
                              		<input type="checkbox" name="module_is_wechat" value="1" >是
                              	</label>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">模块介绍</label>
                          <div class="col-sm-10">
                              <textarea name="module_introduction" class="form-control" placeholder="请输入模块介绍..." cols="30" rows="10"></textarea>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>

                  </div>
            </div>
        </form>
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

                    $("[name='module_thumb']").val(images[0]);
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
    <script>
        function post(event) {
            event.preventDefault();
            require(['util'],function(util){
                util.submit({
                    successUrl: "{{u('index')}}",
                });
            });

        }
    </script>
</block>


