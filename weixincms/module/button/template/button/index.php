<extend file='resource/admin/wechat'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1">菜单列表</a></li>
        <li><a href="{{url('button.post')}}" >菜单添加</a></li>
    </ul>
    <table class="table table-hover">
    	<thead>
    		<tr>
    			<th width="8%">编号</th>
    			<th>菜单标题</th>
    			<th>操作</th>
    		</tr>
    	</thead>
    	<tbody>
        <foreach from="$field" value="$d">
    		<tr>
    			<td>{{$d['id']}}</td>
    			<td>{{$d['title']}}</td>
    			<td>
                    <div class="btn-group btn-group-sm">
                        <if value="$d['state']==1">
                            <a href="javascript:;" class="btn btn-info">使用中</a>
                            <else/>
                            <a href="{{url('button.push','',['id'=>$d['id']])}}" class="btn btn-primary">推送</a>
                        </if>
                        <a href="{{url('button.post')}}&id={{$d['id']}}" class="btn btn-success">编辑</a>
                        <a href="javascript:;" onclick="del({{$d['id']}})" class="btn btn-danger">删除</a>
                    </div>
                </td>
    		</tr>
        </foreach>
    	</tbody>
    </table>
    <script>
        function del(id) {
            util.confirm('确定删除吗',function(res){
                location.href = "{{url('button.del')}}&id="+id;
            })
        }
    </script>
</block>
