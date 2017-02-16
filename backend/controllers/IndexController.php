<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Admin;

class IndexController extends controller
{
	//首页
	public function actionIndex()
	{
		return $this->renderpartial('login.html');
	}

	//安全退出，退出时销毁session
	public function actionLogout()
	{
		$session = Yii::$app->session;
		unset($session['uname']);
		$this->redirect(['index/index']);
	}

	/**
	 * 登陆后展示的首页
	 * @param @uname 用户名（存在session中）
	 * @return 跳转到index.html页面
	 */
	public function actionIn()
	{
		$uname = Yii::$app->session['uname'];
		if(!$uname)
		{
			$this->redirect(['/index/index']);
		}
		return $this->renderpartial('index.html',['uname'=>$uname]);
	}

	/**
	 * 登陆后首页的头部
	 * @param @uname 用户名（存在session中）
	 * @return 跳转到main.html页面
	 */
	public function actionMain()
	{
		$uname = Yii::$app->session['uname'];
		if(!$uname)
		{
			$this->redirect(['/index/index']);
		}
		return $this->renderpartial('main.html',['uname'=>$uname]);
	}

	/**
	 * 登录时判断用户是否正确
	 * @return true展示首页
	 * @return false返回登录界面
	 */
	public function actionLogin_do()
    {
    	$uname = Yii::$app->session['uname'];
		if(!$uname)
		{
			$this->redirect(['/index/index']);
		}
    	$username=Yii::$app->request->post('UserName');
    	$password=md5(Yii::$app->request->post('password'));
    	//echo $username.$password;die;
    	$result=Admin::find()->where(['admin_name'=>$username,'pwd'=>$password])->one();
    	// echo '<pre>';
    	// print_r($result);die;
		if($result){
			Yii::$app->session['uname']=$username;
			$this->redirect(array('/index/in'));
			//跳转页面  数组中第二个参数是传值
		}else{
			$this->redirect(array('/index/index'));

		}
    }
}
?>