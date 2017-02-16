<?php
namespace backend\controllers;
	header('content-type:text/html;charset=utf-8');
use Yii;
use yii\web\Controller;
use backend\models\Admin;
use backend\models\AdminRole;

class MyController extends Controller
{
	//类似于__construct 
	public function init()
	{
		$this->actionCheck_login();
		$this->actionRbac();
	}

	//防非法登陆
	public function actionCheck_login()
	{
		$uname = Yii::$app->session['uname'];
		if(!$uname)
		{
			$this->redirect(['/index/index']);
		}
	}

	//权限控制RBVC
	public function actionRbac()
	{
		$requestedRoute = $this->module->requestedRoute;
		$gang = strpos($requestedRoute,'/');
		$controller = $this->id;
		$method = substr($requestedRoute,$gang+1);
		$uname = Yii::$app->session['uname'];
		//根据用户名查询相关权限
		$re = Admin::find()
		->select('*')
		->join('JOIN','qs_admin_role as ar','qs_admin.admin_id = ar.admin_id')
		->join('JOIN','qs_role as r','ar.role_id = r.role_id')
		->join('JOIN','qs_role_power as rp','r.role_id = rp.role_id')
		->join('JOIN','qs_power as p','rp.power_id = p.power_id')
		->where(['qs_admin.admin_name'=>$uname])
		->asArray()->all();
		//循环获取controller和method
		foreach($re as $k => $v)
		{
			$limit['controller'][$k] = $v['power_conteollers'];
			$limit['method'][$k] = $v['power_methods'];
		}
		//取出数组中重复的数据
		foreach($limit as $k=>$v)
		{
			$limit_last[] = array_unique($v);
		}
		//判断当控制器名和方法名都能有访问权限时才可以，否则提示没有权限
		if(in_array($controller,$limit_last[0]) && in_array($method,$limit_last[1]))
		{
			
		}
		else
		{
			echo "<script>alert('您的权限不够')</script>";
			die;
		}
	}

}

?>