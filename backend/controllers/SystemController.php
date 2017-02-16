<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Admin;
use backend\models\NewCaptcha;
use backend\models\Filter;
use backend\models\FilterIp;

class SystemController extends MyController
{
	//跳转安全设置页面
	public function actionSafe()
	{
		$method = $this->action->id;
		$model = new NewCaptcha;
		$data = $model::find()->where(['captcha_id'=>3])->asArray()->one();
		$data['data'] = $data;
		return $this->renderpartial('sys_index.html',$data);
	}

	//安全设置中验证码
	public function actionCaptcha()
	{
		$data = Yii::$app->request->post();
		// echo '<pre>';
		// print_r($data);
		$model = new NewCaptcha;
		if($info = $model::find()->where(['captcha_id'=>3])->one())
		{
			$info->setAttributes($data);
			$info->save();
			$this->redirect(['system/safe']);
		}
		else
		{
			//$_model = clone $model;
			$model->setAttributes($data);
			$model->save();
			$this->redirect(['system/safe']);
		}

	}

	//安全设置中过滤关键字
	public function actionFilter()
	{
		$data = Yii::$app->request->post();
		$model = new Filter;
		$model->setAttributes($data);
		$model->save();
		$this->redirect(['system/safe']);

	}

	//安全设置中禁止ip
	public function actionIp()
	{
		$data = Yii::$app->request->post();
		$model = new FilterIp;
		$model->setAttributes($data);
		$model->save();
		$this->redirect(['system/safe']);
	}
	
}

?>