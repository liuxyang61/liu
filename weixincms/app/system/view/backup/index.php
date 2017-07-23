<extend file='resource/admin/system'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1">数据备份</a></li>
    </ul>
    <table class="table table-hover">
        <thead>
        <tr>
            <th width="8%">编号</th>
            <th>备份目录</th>
            <th>备份时间</th>
            <th>备份大小</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <foreach from="$dirs" key="$k" value="$d">
            <tr>
                <td>{{$k+1}}</td>
                <td>{{$d['path']}}</td>
                <td>{{date('Y/m/d H:i',$d['filemtime'])}}</td>
                <td>{{Tool::getSize($d['size'],2)}}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="javascript:;" onclick="recovery('{{$d['path']}}')" class="btn btn-success">还原</a>
                        <a href="javascript:;" onclick="del('{{$d['path']}}')" class="btn btn-danger">删除</a>
                    </div>
                </td>
            </tr>
        </foreach>
        </tbody>
    </table>
    <script>
        //还原
        function recovery(path) {
            util.confirm('确定还原备份？', function (res) {
                location.href = "{{u('recovery')}}&path=" + path;
            })
        }
        //删除
        function del(path) {
            util.confirm('确定删除备份？', function (res) {
                location.href = "{{u('del')}}&path=" + path;
            })
        }
    </script>
</block>
