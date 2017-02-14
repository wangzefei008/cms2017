<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use app\models\Admin;

class IndexController extends controller
{
	//首页
	public function actionIndex()
	{
		return $this->renderpartial('login.html');
	}

	public function actionIn()
	{
		$uname = Yii::$app->session['uname'];
		return $this->renderpartial('index.html',['uname'=>$uname]);
	}

	public function actionMain()
	{
		$uname = Yii::$app->session['uname'];
		return $this->renderpartial('main.html',['uname'=>$uname]);
	}

	public function actionLogin_do()
    {
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