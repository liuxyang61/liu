<extend file='resource/admin/module'/>
<block name="modulename">
    <li class="list-group-item">
        <a href="">友链列表</a>
    </li>
    <li class="list-group-item">
        <a href="{{url('admin.post')}}">友链添加</a>
    </li>
</block>
<block name="content">
	<!-- TAB NAVIGATION -->
	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#tab1">友链列表</a></li>
		<li><a href="{{url('admin.post')}}">友链添加</a></li>
	</ul>
	<table class="table table-hover">
		<thead>
		<tr>
			<th width="8%">编号</th>
			<th>友链名称</th>
			<th>友链地址</th>
			<th>友链排序</th>
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
		<foreach from="$data" value="$d">
			<tr>
				<td>{{$d['links_id']}}</td>
				<td>
                    <a href="{{$d['links_url']}}" target="_blank">{{$d['links_name']}}</a>
				</td>
				<td>{{$d['links_url']}}</td>
				<td>{{$d['links_orderby']}}</td>
				<td>
					<div class="btn-group btn-group-sm">
							<a href="{{url('admin.post','',['links_id'=>$d['links_id']])}}"  class="btn btn-danger">编辑</a>
							<a href="javascript:;" onclick="del({{$d['links_id']}})"  class="btn btn-success">删除</a>
					</div>
				</td>
			</tr>
		</foreach>
		</tbody>
	</table>
	<script>
        function del(links_id) {
            util.confirm('确定删除吗', function (res) {
                location.href = "{{url('admin.del')}}&links_id=" + links_id;
            })
        }
	</script>
</block>
