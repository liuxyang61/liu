<extend file='resource/admin/module'/>
<block name="modulename">
    <li class="list-group-item">
        <a href="{{url('admin.index')}}">友链列表</a>
    </li>
    <li class="list-group-item">
            <a href="{{url('admin.post')}}">友链添加</a>
    </li>
</block>
<block name="content">
	<!-- TAB NAVIGATION -->
	<ul class="nav nav-tabs" role="tablist">
		<li ><a href="{{url('admin.index')}}">友链列表</a></li>
		<li class="active"><a href="">{{($model['links_id'])?'友链编辑':'友链添加'}}</a></li>
	</ul>
	<form action="" method="POST" class="form-horizontal" role="form">
	    <div class="panel panel-default">
	    	  <div class="panel-heading">
	    			<h3 class="panel-title">友链管理</h3>
	    	  </div>
	    	  <div class="panel-body">
                  <div class="form-group">
                      <label for="" class="col-sm-2 control-label">友链名称</label>
                      <div class="col-sm-10">
                          <input type="text"  class="form-control" value="{{$model['links_name']}}" name="links_name">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="" class="col-sm-2 control-label">友链链接</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" value="{{$model['links_url']}}" name="links_url">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="" class="col-sm-2 control-label">友链排序</label>
                      <div class="col-sm-10">
                          <input type="number" class="form-control" value="{{$model['links_orderby'] ? : 10}}" name="links_orderby">
                      </div>
                  </div>
              </div>
	    </div>
        <button class="btn btn-success">提交</button>
	</form>
</block>
