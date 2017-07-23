<?php namespace app\system\controller;

use houdunwang\dir\Dir;
use houdunwang\request\Request;
use houdunwang\route\Controller;
use houdunwang\backup\Backup as BackupModel;

class Backup extends Controller
{

	//动作
	public function index ()
	{
	    //获取所有备份列表目录
		$dirs = BackupModel::getBackupDir( 'backup' );
		//		p($dirs);
		//此处书写代码...
		return view( '' , compact( 'dirs' ) );
	}

	/**
	 * 执行备份
	 */
	public function run ()
	{
		$config = [
			'size' => 200 ,//分卷大小单位KB
			'dir'  => 'backup/' . date( "Ymdhis" ) ,//备份目录
		];
		$status = BackupModel::backup(
			$config , function ( $result ) {
			if ( $result[ 'status' ] == 'run' ) {
				//备份进行中
				$message = $result[ 'message' ];
				die( view( 'message' , compact( 'message' ) ) );

				//				echo $result[ 'message' ];
				//刷新当前页面继续下次
			} else {
				//备份执行完毕
				//echo $result[ 'message' ];
				die( $this->setRedirect( 'index' )->success( $result[ 'message' ] ) );
			}
		}
		);
		if ( $status === false ) {
			//备份过程出现错误
			//echo BackupModel::getError();
			die( $this->error( BackupModel::getError() ) );
		}
	}

	/**
	 * 还原备份数据
	 */
	public function recovery ()
	{
		//要还原的备份目录
		$config = [ 'dir' => Request::get('path')];
		$status = BackupModel::recovery(
			$config , function ( $result ) {
			if ( $result[ 'status' ] == 'run' ) {
				//还原
				$message = $result[ 'message' ];
				die( view( 'message' , compact( 'message' ) ) );
			} else {
				//还原执行完毕
				die( $this->setRedirect( 'index' )->success( $result[ 'message' ] ) );
			}
		}
		);
		if ( $status === false ) {
			//还原过程出现错误
			die( $this->error( BackupModel::getError() ) );
		}
	}

	/**
	 * 删除备份
	 */
	public function del ()
	{
	    //获取路径
		$path = Request::get( 'path' );
		//删除备份目录
		Dir::del( $path );
		return $this->setRedirect( 'index' )->success( '操作成功' );
	}
}
