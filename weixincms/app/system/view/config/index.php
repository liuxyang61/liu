<extend file='resource/admin/system'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="{{u('index')}}">系统配置</a></li>
    </ul>
    <!-- TAB CONTENT -->
        <form action="" method="POST" class="form-horizontal" role="form" onsubmit="return post(event)">
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title">网站配置</h3>
            	  </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">网站名称</label>
                    <div class="col-sm-4">
                        <input type="text" name="webname" value="{{v('config.webname')}}" class="form-control" required="required" >
                    </div>

                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">网站描述</label>
                    <div class="col-sm-4">
                        <input type="text" name="description" value="{{v('config.description')}}" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">站长邮箱</label>
                    <div class="col-sm-4">
                        <input type="text" name="email" value="{{v('config.email')}}" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">客服电话</label>
                    <div class="col-sm-4">
                        <input type="text" name="tel" value="{{v('config.tel')}}" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">备案号</label>
                    <div class="col-sm-4">
                        <input type="text" name="icp" value="{{v('config.icp')}}" class="form-control" required="required">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">设置前台加载模板</label>
                    <div class="col-sm-4">
                        <select name="template"  class="form-control">
                            <?php foreach(glob('template/web/*') as $v){?>
                                <option <?php if($field['template'] ==basename($v)){ ?>selected<?php } ?>  value="<?php echo basename($v); ?>">  <?php echo basename($v); ?>  </option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">NUM配置项</h3>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">文章分页数量</label>
                    <div class="col-sm-4">
                        <input type="text" name="arc_num" value="{{v('config.arc_num')}}" class="form-control" required="required" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">验证码位数</label>
                    <div class="col-sm-4">
                        <input type="text" name="code" value="{{v('config.code')}}" class="form-control" required="required" >
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">提交</button>
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


