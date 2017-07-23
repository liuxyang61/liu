<extend file='resource/admin/base'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1">文章管理</a></li>
        <li><a href="{{u('post')}}" >文章添加</a></li>
    </ul>
    <table class="table table-hover">
        <thead>
        <tr>
            <th width="8%">编号</th>
            <th width="20%">文章标题</th>
            <th width="20%">文章描述</th>
            <th>文章作者</th>
            <th>发布时间</th>
            <th>操作</th>
        </tr>
        </thead>
    	<tbody>
            <foreach from="$field" value="$d">
                <tr>
                <td>{{$d['arc_id']}}</td>
    			<td width="20%" style="white-space:nowrap;
    			text-overflow:ellipsis;
    			-o-text-overflow:ellipsis;overflow: hidden; ">{{$d['arc_title']}}</td>
    			<td width="40%" style="white-space:nowrap;text-overflow:ellipsis;-o-text-overflow:ellipsis;overflow: hidden;" >{{$d['arc_description']}}</td>
                <td>{{$d['arc_author']}}</td>
                <td>{{$d['created_at']}}</td>
    			<td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{u('post',['arc_id'=>$d['arc_id']])}}" class="btn btn-success">编辑</a>
                        <a href="javascript:;" onclick="del({{$d['arc_id']}})" class="btn btn-danger">删除</a>
                    </div>
                </td>
                </tr>
         </foreach>
    </tbody>
    </table>
    {{$page}}
    <script>
        function del(arc_id) {
            util.confirm('确定删除吗?',function(res){
                location.href = "{{u('del')}}&arc_id=" + arc_id;
            })
        }
    </script>
</block>
