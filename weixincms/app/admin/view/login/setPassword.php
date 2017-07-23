<extend file='resource/admin/base'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#">用户密码</a></li>
    </ul>
    <!-- TAB CONTENT -->
    <form action="" method="POST" class="form-horizontal" role="form" onsubmit="return post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">修改密码</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">请输入新密码</label>
                    <div class="col-sm-6">
                        <input type="text" name="newpasswordOne" value="" class="form-control" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">请再次输入密码</label>
                    <div class="col-sm-6">
                        <input type="text" name="newpasswordTwo" value="" class="form-control" id="" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">请输入验证码</label>
                    <img src="{{u('admin.login.code')}}" onclick="this.src=this.src+'&rand='+Math.random()" alt="">
                    <div class="col-sm-6">
                        <input type="text" name="passcode" value="" class="form-control" id="" placeholder="">
                    </div>
                </div>




            </div>
        </div>

        <button type="submit" class="btn btn-primary">确定</button>

    </form>

    <script>
        function post(event) {
            //阻止表单默认行为
            event.preventDefault();
            require(['util'], function (util) {
                util.submit({
                    successUrl:"refresh",
                });
            });
        }
    </script>

</block>


