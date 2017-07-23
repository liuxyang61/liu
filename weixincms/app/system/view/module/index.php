<extend file='resource/admin/module'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1">模块列表</a></li>
        <li><a href="{{u('design')}}" >设计模块</a></li>
    </ul>
    <table class="table table-hover">
    	<thead>
    		<tr>
    			<th>模块中文名称</th>
    			<th>模块标识</th>
    			<th>模块作者</th>
    			<th>缩略图</th>
    			<th>操作</th>
    		</tr>
    	</thead>
    	<tbody>
        <foreach from="$data" value="$d">
    		<tr>
                <td>{{$d['module_title']}}</td>
    			<td>{{$d['module_name']}}</td>

    			<td>{{$d['module_author']}}</td>
                <td>
                    <img style="height: 60px;" src="{{$d['module_thumb']}}" alt="">
                </td>
    			<td>
                    <div class="btn-group btn-group-sm">
                        <if value="$d['isinstall']">
                            <a href="javacript:;" onclick="uninstall('{{$d['module_name']}}')" class="btn btn-danger">卸载</a>
                            <else/>
                            <a href="{{u('insatall',['module_name'=>$d['module_name']])}}" class="btn btn-success">安装</a>
                        </if>
                    </div>
                </td>
    		</tr>
        </foreach>
    	</tbody>
    </table>
    <script>

        function uninstall(module_name) {
            util.confirm('确定卸载吗?',function(res){
                location.href = "{{u('uninstall')}}&module_name=" +module_name;
//                alter(1);
            })
        }
    </script>
</block>
