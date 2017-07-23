<extend file='resource/admin/base'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1">轮播图列表</a></li>
        <li><a href="{{u('post')}}">轮播图添加</a></li>
    </ul>
    <table class="table table-hover">
        <thead>
        <tr>
            <th width="8%">编号</th>
            <th width="20%">标题</th>
            <th width="20%">缩略图</th>
            <th>发布时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <foreach from="$field" value="$d">
            <tr>
                <td>{{$d['slide_id']}}</td>
                <td>{{$d['slide_title']}}</td>
                <td>
                    <img style="height: 50px;" src=" {{$d['slide_thumb']}}" alt="">
                </td>
                <td>{{$d['created_at']}}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{__ROOT__}}/{{$d['slide_thumb']}}" class="btn btn-info">预览</a>
                        <a href="{{u('post',['slide_id'=>$d['slide_id']])}}" class="btn btn-success">编辑</a>
                        <a href="javascript:;" onclick="del({{$d['slide_id']}})" class="btn btn-danger">删除</a>
                    </div>
                </td>
            </tr>
        </foreach>
        </tbody>
    </table>
    {{$page}}
    <script>
        function del(slide_id) {
            util.confirm('确定删除吗?', function (res) {
                location.href = "{{u('del')}}&slide_id=" + slide_id;
            })
        }
    </script>

</block>
