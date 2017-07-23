<extend file='resource/admin/wechat'/>
<block name="content">
	<!-- TAB NAVIGATION -->
	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#">微信功能</a></li>
	</ul>
	<!-- TAB CONTENT -->
	<form action="" method="POST" class="form-horizontal" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">微信配置</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">token</label>
					<div class="col-sm-6">
						<input type="text" name="token" value="{{$field['token']}}" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">appid</label>
					<div class="col-sm-6">
						<input type="text" name="appid" value="{{$field['appid']}}" class="form-control" id="" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">appsecret</label>
					<div class="col-sm-6">
						<input type="text" name="appsecret" value="{{$field['appsecret']}}" class="form-control" id="" placeholder="">
					</div>
				</div>


			</div>
		</div>

		<button type="submit" class="btn btn-primary">确定</button>

	</form>


</block>


