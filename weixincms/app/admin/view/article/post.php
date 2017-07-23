<extend file='resource/admin/base'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li ><a href="{{u('index')}}">文章首页</a></li>
        <li class="active"><a href="{{u('post')}}" >{{$oldData['arc_id']?'文章编辑':'文章添加'}}</a></li>
    </ul>
    <!-- TAB CONTENT -->
        <form action="" method="POST" class="form-horizontal" role="form" onsubmit="return post(event)">
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title">文章管理</h3>
            	  </div>
            	  <div class="panel-body">
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">所属栏目</label>
                          <div class="col-sm-10">
                              <select name="cate_cid" id="inputID" class="form-control">
                                  <option value="0"> -- 请选择 -- </option>
                                  <foreach from="$cateData" value="$d">
                                      <option <if value="$oldData['cate_cid']==$d['cate_id']">selected</if> value="{{$d['cate_id']}}"> -- {{$d['_cate_name']}} -- </option>
                                  </foreach>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">文章标题</label>
                          <div class="col-sm-10">
                              <input type="text"  name="arc_title" value="{{$oldData['arc_title']}}" class="form-control" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">文章作者</label>
                          <div class="col-sm-10">

                              <input type="text" name="arc_author" value="{{$oldData['arc_author']}}" class="form-control" id="" placeholder="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">点击次数</label>
                          <div class="col-sm-10">
                              <input type="number" name="arc_click" value="{{$oldData['arc_click']}}" class="form-control" id="" placeholder="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">文章排序</label>
                          <div class="col-sm-10">

                              <input type="text" name="arc_orderby" value="{{$oldData['arc_orderby']}}" class="form-control" id="" placeholder="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">文章来源</label>
                          <div class="col-sm-10">

                              <input type="text" name="arc_source" value="{{$oldData['arc_source']}}" class="form-control" id="" placeholder="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">属性</label>
                          <div class="col-sm-10">
                              <div class="checkbox">
                                  <label>

                                      <input type="checkbox" value="1"  name="arc_ishot" <if value="$oldData['arc_ishot']==1">checked </if> > 热门
                                  </label>
                                  <label>
                                      <input type="checkbox" value="1" name="arc_iscommed" <if value="$oldData['arc_iscommed']==1">checked </if>  > 推荐
                                  </label>
                              </div>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">文章缩略图</label>
                          <div class="col-sm-10">
                              <div class="input-group">
                                  <input type="text" class="form-control" name="arc_thumb" readonly="" value="{{$oldData['arc_thumb']}}">
                                  <div class="input-group-btn">
                                      <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
                                  </div>
                              </div>
                              <div class="input-group" style="margin-top:5px;">
                                  <img src="{{pic($oldData['arc_thumb'],'resource/images/nopic.jpg')}}" class="img-responsive img-thumbnail" width="150">
                                  <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">文章关键字</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="arc_keyword" value="{{$oldData['arc_keyword']}}">
                              <span class="help-block">微信关键字</span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">外部链接</label>
                          <div class="col-sm-10">
                              <input type="text" name="arc_linkurl" value="{{$oldData['arc_linkurl']}}" class="form-control" id="" placeholder="">
                              <span class="help-block">如果有链接的话，点击直接跳转指定链接</span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">文章描述</label>
                          <div class="col-sm-10">
                              <textarea name="arc_description" class="form-control" cols="30" rows="10">{{$oldData['arc_description']}}</textarea>
                          </div>
                      </div>


                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">文章内容</label>
                          <div class="col-sm-10">
                              <textarea id="container" name="arc_content" style="height:300px;width:100%;">{{$oldData['arc_content']}}</textarea>
                              <script>
                                  util.ueditor('container', {hash:2,data:'hd'}, function (editor) {
                                      //这是回调函数 editor是百度编辑器实例
                                  });
                              </script>
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
                    $("[name='arc_thumb']").val(images[0]);
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


