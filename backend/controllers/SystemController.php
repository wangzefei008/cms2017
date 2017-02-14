<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

class SystemController extends Controller
{
	//跳转安全设置页面
	public function actionSafe()
	{
		return $this->renderpartial('sys_index.html');
	}

}

?>