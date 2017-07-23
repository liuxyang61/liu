<extend file='resource/admin/module'/>
<block name="modulename">
    <li class="list-group-item">
        <a href="{{url('admin.index')}}">热搜列表</a>
    </li>
    <li class="list-group-item">
            <a href="{{url('admin.post')}}">热搜添加</a>
    </li>
</block>
<block name="content">
	<!-- TAB NAVIGATION -->
	<ul class="nav nav-tabs" role="tablist">
		<li ><a href="{{url('admin.index')}}">热搜列表</a></li>
		<li class="active"><a href="">{{($model['search_id'])?'热搜编辑':'热搜添加'}}</a></li>
	</ul>
	<form action="" method="POST" class="form-horizontal" role="form">
	    <div class="panel panel-default">
	    	  <div class="panel-heading">
	    			<h3 class="panel-title">热门搜索</h3>
	    	  </div>
	    	  <div class="panel-body">
                  <div class="form-group">
                      <label for="" class="col-sm-2 control-label">热搜名称</label>
                      <div class="col-sm-10">
                          <input type="text"  class="form-control" value="{{$model['search_name']}}" name="search_name">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="" class="col-sm-2 control-label">搜索次数</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" value="{{$model['search_num']}}" name="search_num">
                      </div>
                  </div>
              </div>
	    </div>
        <button class="btn btn-success">提交</button>
	</form>
</block>
