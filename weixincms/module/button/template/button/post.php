<extend file='resource/admin/wechat'/>
<block name="content">
    <link rel="stylesheet" href="{{__ROOT__}}/resource/css/index.css">
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li ><a href="{{url('button.index')}}">菜单列表</a></li>
        <li class="active"><a href="{{url('button.post')}}" >菜单添加</a></li>
    </ul>
    <div class="panel panel-default">
    	  <div class="panel-body" ng-controller="ctrl">
              <form action="" method="POST" class="form-horizontal" role="form" ng-controller="ctrl">
                  <div class="container" style="width: 100%">
                      <div class="row">
                          <!--手机预览-->
                          <div class="col-xs-4">
                              <div class="mobile" style="background: url('{{__ROOT__}}/module/button/template/button/333.jpg')">
                                  <dl ng-repeat="(k,v) in data.button">
                                      <dt ng-bind="v.name"></dt>
                                      <dd>
                                          <a href="" ng-repeat="(m,n) in v.sub_button" ng-bind="n.name"></a>
                                      </dd>
                                  </dl>
                              </div>
                          </div>
                          <!--编辑页面-->
                          <div class="col-xs-8">
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h3 class="panel-title">编辑</h3>
                                  </div>
                                  <div class="panel-body">
                                      <div class="form-group">
                                          <label for="" class="col-sm-2 control-label">菜单标题</label>
                                          <div class="col-sm-10">
                                              <input ="" type="text" name="title" class="form-control" value="{{$model['title']}}">
                                          </div>
                                      </div>
                                      <!--一级菜单开始-->
                                      <div class="panel panel-default topMenu" ng-repeat="(k,v) in data.button">
                                          <i class="fa fa-times-circle fa-2x top" ng-click="delTopMenu(v)"></i>
                                          <div class="panel-body">
                                              <div class="form-group">
                                                  <label for="" class="col-sm-2 control-label">菜单名称</label>
                                                  <div class="col-sm-10">
                                                      <input type="text" ng-model="v.name" class="form-control">
                                                  </div>
                                              </div>
                                              <div class="form-group" ng-if="!v.sub_button ||  v.sub_button.length==0">
                                                  <label for="" class="col-sm-2 control-label">类型</label>
                                                  <div class="col-sm-10">
                                                      <div class="radio">
                                                          <label>
                                                              <input type="radio" ng-model="v.type" ng-value="'click'">关键词
                                                          </label>
                                                          <label>
                                                              <input type="radio" ng-model="v.type" ng-value="'view'">url
                                                          </label>
                                                      </div>
                                                  </div>
                                              </div>
                                              <!--{{v.type}}-->
                                              <div class="form-group" ng-if="v.type=='click' && (!v.sub_button ||  v.sub_button.length==0)">
                                                  <label for="" class="col-sm-2 control-label">关键词</label>
                                                  <div class="col-sm-10">
                                                      <input type="text" ng-model="v.key" class="form-control">
                                                  </div>
                                              </div>
                                              <div class="form-group" ng-if="v.type=='view' && (!v.sub_button ||  v.sub_button.length==0)">
                                                  <label for="" class="col-sm-2 control-label">url</label>
                                                  <div class="col-sm-10">
                                                      <input type="text" ng-model="v.url" class="form-control">
                                                  </div>
                                              </div>
                                              <!--二级菜单开始-->
                                              <div class="panel panel-default subMenu" ng-repeat="(m,n) in v.sub_button">
                                                  <i class="fa fa-times-circle fa-2x sub" ng-click="delSubMenu(v,n)"></i>

                                                  <div class="panel-body">
                                                      <div class="form-group">
                                                          <label for="" class="col-sm-2 control-label">菜单名称</label>
                                                          <div class="col-sm-10">
                                                              <input type="text" ng-model="n.name" class="form-control">
                                                          </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="" class="col-sm-2 control-label">类型</label>
                                                          <div class="col-sm-10">
                                                              <div class="radio">
                                                                  <label>
                                                                      <input type="radio" ng-model="n.type" ng-value="'click'">关键词
                                                                  </label>
                                                                  <label>
                                                                      <input type="radio" ng-model="n.type" ng-value="'view'">url
                                                                  </label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="form-group" ng-if="n.type=='click'">
                                                          <label for="" class="col-sm-2 control-label">关键词</label>
                                                          <div class="col-sm-10">
                                                              <input type="text" ng-model="n.key" class="form-control">
                                                          </div>
                                                      </div>
                                                      <div class="form-group" ng-if="n.type=='view'">
                                                          <label for="" class="col-sm-2 control-label">url</label>
                                                          <div class="col-sm-10">
                                                              <input type="text" ng-model="n.url" class="form-control">
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <button class="btn btn-info" ng-click="addSubMenu(v)" type="button">添加二级菜单</button>
                                              <!--二级菜单结束-->
                                          </div>
                                      </div>
                                      <button class="btn btn-success" ng-click="addTopMenu()" type="button">添加一级菜单</button>
                                      <!--一级菜单结束-->
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <input hidden name="content" type="text" value="@{{data.button}}">
                  <input type="submit" class="btn btn-primary" value="提交数据">
              </form>
          </div>
    </div>
    <script>
        function controller($scope, $, _) {
            $scope.data =  {
                "button":<?php echo $model['content']?>
            }
            //添加一级菜单
            $scope.addTopMenu = function () {
                var html = {
                    "type":"",
                    "name":"",
                    "key":""
                };
                if( $scope.data.button.length==3){
                    alert('一级菜单最多添加三个');
                }else{
                    $scope.data.button.push(html);
                }
            }
            //添加二级
            $scope.addSubMenu = function (topMenu) {
                var html = {
                    "type":"",
                    "name":"",
                    "key":""
                };
                if(!topMenu.sub_button){topMenu.sub_button=[]}
                if(topMenu.sub_button.length==5){
                    alert('二级菜单最多添加五个');
                }else{
                    topMenu.sub_button.push(html);
                }
            }
            //删除一级菜单
            $scope.delTopMenu = function (topMenu) {
                $scope.data.button =  _.without($scope.data.button,topMenu);
            }
            //删除二级菜单
            $scope.delSubMenu = function (topMenu,subMenu) {
                topMenu.sub_button = _.without(topMenu.sub_button,subMenu)
            }
        }
    </script>
</block>


