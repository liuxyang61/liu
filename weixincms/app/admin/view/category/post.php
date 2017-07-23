<extend file='resource/admin/base'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li ><a href="{{u('index')}}">栏目首页</a></li>
        <li class="active"><a href="{{u('store')}}" >栏目添加</a></li>
    </ul>
    <!-- TAB CONTENT -->
        <form action="" method="POST" class="form-horizontal" role="form" onsubmit="return post(event)">
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title">栏目管理</h3>
            	  </div>
            	  <div class="panel-body">
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">栏目名称</label>
                          <div class="col-sm-10">
                              <input type="text" name="cate_name" value="{{$oldData['cate_name']}}" class="form-control" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">栏目排序</label>
                          <div class="col-sm-10">
                              <input type="text" name="cate_sort" value="{{$oldData['cate_sort']}}" class="form-control" id="" placeholder="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">栏目外部链接</label>
                          <div class="col-sm-10">
                              <input type="text" name="cate_linkurl" value="{{$oldData['cate_linkurl']}}" class="form-control" id="" placeholder="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">所属栏目</label>
                          <div class="col-sm-10">
                              <select name="cate_pid" id="inputID" class="form-control">
                              	<option value="0"> -顶级栏目- </option>
                                  <foreach from="$cateData" value="$d">
                                      <option <if value="$oldData['cate_pid']==$d['cate_id']">selected</if> value="{{$d['cate_id']}}"> -{{$d['_cate_name']}}- </option>
                                  </foreach>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">栏目描述</label>
                          <div class="col-sm-10">
                              <textarea name="cate_description" class="form-control" cols="30" rows="10">{{$oldData['cate_description']}}</textarea>
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

</block>


