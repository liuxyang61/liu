<extend file='resource/admin/wechat'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="{{url('base.index')}}">微信基本消息管理</a></li>
        <li><a href="{{url('base.post')}}" >添加基本回复</a></li>
    </ul>
    <table class="table table-hover">
        <thead>
        <tr>
            <th width="8%">编号</th>
            <th>关键词</th>
            <th>回复内容</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <foreach from="$base" value="$d">
            <tr>
                <td>{{$d['id']}}</td>
                <td>{{$d['keywords']}}</td>
                <td>{{$d['content']}}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{url('base.post')}}&id={{$d['id']}}"  class="btn btn-success">编辑</a>
                        <a href="javascript:;" onclick="del({{$d['id']}})" class="btn btn-danger">删除</a>
                    </div>
                </td>
            </tr>
        </foreach>
        </tbody>
    </table>

    <script>
        function del(id) {
            util.confirm('确定删除吗？',function (res) {
                location.href="{{url('base.del')}}&id="+id;
            })
        }
    </script>
</block>
