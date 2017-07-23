<extend file='resource/admin/module'/>
<block name="modulename">
    <li class="list-group-item">
        <a href="">热搜列表</a>
    </li>
    <li class="list-group-item">
        <a href="{{url('admin.post')}}">热搜添加</a>
    </li>
</block>
<block name="content">
	<!-- TAB NAVIGATION -->
	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#tab1">热搜列表</a></li>
		<li><a href="{{url('admin.post')}}">热搜添加</a></li>
	</ul>
	<table class="table table-hover">
		<thead>
		<tr>
			<th width="8%">编号</th>
			<th>热搜名称</th>
			<th>热搜量</th>
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
		<foreach from="$data" value="$d">
			<tr>
				<td>{{$d['search_id']}}</td>
				<td>{{$d['search_name']}}</td>
				<td>{{$d['search_num']}}</td>
				<td>
					<div class="btn-group btn-group-sm">
							<a href="{{url('admin.post','',['search_id'=>$d['search_id']])}}"  class="btn btn-danger">编辑</a>
							<a href="javascript:;" onclick="del({{$d['search_id']}})"  class="btn btn-success">删除</a>
					</div>
				</td>
			</tr>
		</foreach>
		</tbody>

	</table>
    {{$page}}
	<script>
        function del(search_id) {
            util.confirm('确定删除吗', function (res) {
                location.href = "{{url('admin.del')}}&search_id=" + search_id;
            })
        }
	</script>
</block>
