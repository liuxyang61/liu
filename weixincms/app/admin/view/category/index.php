<extend file='resource/admin/base'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1">栏目首页</a></li>
        <li><a href="{{u('post')}}" >栏目添加</a></li>
    </ul>
    <table class="table table-hover" style="table-layout:fixed;">
        <thead>
        <tr>
            <th width="8%">编号</th>
            <th  width="20%">栏目名称</th>
            <th width="30%">栏目详情</th>
            <th width="10%">操作栏目</th>
        </tr>
        </thead>
        <tbody>
        <foreach from="$cateData" value="$d">
            <tr>
                <td>{{$d['cate_id']}}</td>
                <td>{{$d['_cate_name']}}</td>
                <td style="overflow:hidden;text-overflow:ellipsis;word-break:keep-all;white-space:nowrap;" >{{$d['cate_description']}}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{u('post',['cate_id'=>$d['cate_id']])}}" class="btn btn-success">编辑</a>
                        <a href="javacript:;" onclick="del({{$d['cate_id']}})" class="btn btn-danger">删除</a>
                    </div>
                </td>
            </tr>
        </foreach>
        </tbody>
    </table>
    <script>
        function del(cid) {
            util.confirm('删除当前栏目后,所有子级栏目都将清除!!!确定删除吗?',function(){
                location.href="index.php?s=admin/category/del&cate_id="+cid;
            })


        }
    </script>
</block>
