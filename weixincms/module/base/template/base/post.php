<extend file='resource/admin/wechat'/>
<block name="content">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li ><a href="{{url('base.index')}}">微信基本消息管理</a></li>
        <li class="active"><a href="{{url('base.post')}}" >添加基本回复</a></li>
    </ul>
    <!-- TAB CONTENT -->
        <form action="" method="POST" class="form-horizontal" role="form" onsubmit="return post(event)">
            <include file="resource/view/keywords.php"/>
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title">回复内容管理</h3>
            	  </div>
            	  <div class="panel-body">
                      <div class="form-group">
                          <label for="" class="col-sm-2 control-label">回复内容</label>
                          <div class="col-sm-10">
                              <textarea name="content"  class="form-control" cols="30" rows="5">{{$base[0]['content']}}</textarea>
                          </div>
                      </div>
                  </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>

    <script>
        function post(event) {
            //阻止表单默认行为
            event.preventDefault();
            require(['util'], function (util) {
                util.submit({
                    successUrl:"{{url('base.index')}}",
                });
            });
        }
    </script>
</block>


