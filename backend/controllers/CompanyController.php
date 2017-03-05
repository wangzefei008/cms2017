<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Jobs;
use yii\data\Pagination;
use backend\models\CompanyProfile;


class CompanyController extends MyController
{
	//职位列表
	public function actionPosition()
	{
		$model = new Jobs;
		$arr=$model->find();
		//$countQuery = clone $arr;
		$pages = new Pagination
		([
			//'totalCount' => $countQuery->count(),
			'totalCount' => $arr->count(),
			'pageSize'   => 2   //每页显示条数
		]);
		$models = $arr
			->offset($pages->offset)
			->limit($pages->limit)
			->asArray()
			->all();

		foreach($models as $k=>$v)
		{
			$addtime = $models[$k]['addtime'];
			$deadline = $models[$k]['deadline'];
			//echo $addtime,$deadline;die;
			$models[$k]['addtime'] = date("Y-m-d",$addtime);
			$models[$k]['deadline'] = date("Y-m-d",$deadline);
		}

		$val['models'] = $models;
		$val['pages'] = $pages;
		return $this->render('position.html',$val);
	}

	//接收搜索的ajax值
	public function actionSearch()
	{
		$user_status = isset($_GET['user_status'])?$_GET['user_status']:null;
		$addtime = isset($_GET['add_time'])?$_GET['add_time']:null;
		$deadline = isset($_GET['end_time'])?$_GET['end_time']:null;
		$where = '1=1';
		if(!empty($user_status))
		{
			$where = $where." and user_status=$user_status";
		}
		if(!empty($addtime))
		{
			$time = time()-$addtime;
			$where = $where." and addtime>$time";
		}
		if(!empty($deadline))
		{
			$time = time()+$deadline;
			$where = $where." and deadline<$time";
		}
		// echo '<pre>';
		// print_r($where);die;
		$model = new Jobs;
		$arr=$model->find()->where($where);
		//$countQuery = clone $arr;
		$pages = new Pagination
		([
			//'totalCount' => $countQuery->count(),
			'totalCount' => $arr->count(),
			'pageSize'   => 2   //每页显示条数
		]);
		$models = $arr
			->offset($pages->offset)
			->limit($pages->limit)
			->asArray()
			->all();
		// echo '<pre>';
		// print_r($models);die;
		foreach($models as $k=>$v)
		{
			$addtime = $models[$k]['addtime'];
			$deadline = $models[$k]['deadline'];
			//echo $addtime,$deadline;die;
			$models[$k]['addtime'] = date("Y-m-d",$addtime);
			$models[$k]['deadline'] = date("Y-m-d",$deadline);
		}
		$val['models'] = $models;
		$val['pages'] = $pages;
		// echo '<pre>';
		// print_r($models);die;
		echo json_encode($val);
	}


	// 删除
	public function actionDel()
	{
		//接收传送id
		$id = isset($_GET['id'])?$_GET['id']:null;
		$model = new Jobs;
		$info = $model::find()->where(['id' => $id])->one()->delete();
		if($info)
		{
			$this->redirect(['/company/position']);
		}
		else
		{
			$this->redirect(['/company/position']);
		}
	}

	//修改
	public function actionUpdate()
	{
		$companyname = isset($_GET['val'])?$_GET['val']:null;
		$id = isset($_GET['id'])?$_GET['id']:null;
		$data['companyname'] = $companyname;
		// echo $id;die;
		$model = new Jobs;
		$info = $model::find()->where(['id'=>$id])->one();

		$info->companyname=$companyname;
		// $info->setAttributes($data);
		if($info->save())
		{
			echo 1;
		}
		else
		{
			echo '<pre>';
			print_r($info->errors);
		}
		
	}


	//企业管理
	public function actionManagement()
	{
		$model = new CompanyProfile;
		$arr=$model->find();
		//$countQuery = clone $arr;
		$pages = new Pagination
		([
			//'totalCount' => $countQuery->count(),
			'totalCount' => $arr->count(),
			'pageSize'   => 2   //每页显示条数
		]);
		$models = $arr
			->offset($pages->offset)
			->limit($pages->limit)
			->asArray()
			->all();

		foreach($models as $k=>$v)
		{
			$addtime = $models[$k]['add_time'];
			$refreshtime = $models[$k]['refreshtime'];
			//echo $addtime,$deadline;die;
			$models[$k]['add_time'] = date("Y-m-d",$addtime);
			$models[$k]['refreshtime'] = date("Y-m-d",$refreshtime);
		}

		$val['models'] = $models;
		$val['pages'] = $pages;

		return $this->render('management.html',$val);
	}

	//企业管理搜索
	public function actionSearch1()
	{
		$user_status = isset($_GET['user_status'])?$_GET['user_status']:null;
		$addtime = isset($_GET['add_time'])?$_GET['add_time']:null;
		$where = '1=1';
		if(!empty($user_status))
		{
			$where = $where." and user_status=$user_status";
		}
		if(!empty($addtime))
		{
			$time = time()-$addtime;
			$where = $where." and addtime>$time";
		}
		// echo '<pre>';
		// print_r($where);die;
		$model = new CompanyProfile;
		$arr=$model->find()->where($where);
		//$countQuery = clone $arr;
		$pages = new Pagination
		([
			//'totalCount' => $countQuery->count(),
			'totalCount' => $arr->count(),
			'pageSize'   => 2   //每页显示条数
		]);
		$models = $arr
			->offset($pages->offset)
			->limit($pages->limit)
			->asArray()
			->all();
		// echo '<pre>';
		// print_r($models);die;
		foreach($models as $k=>$v)
		{
			$addtime = $models[$k]['add_time'];
			$refreshtime = $models[$k]['refreshtime'];
			//echo $addtime,$deadline;die;
			$models[$k]['add_time'] = date("Y-m-d",$addtime);
			$models[$k]['refreshtime'] = date("Y-m-d",$refreshtime);
		}
		$val['models'] = $models;
		$val['pages'] = $pages;
		// echo '<pre>';
		// print_r($models);die;
		echo json_encode($val);
	}

	//企业管理修改
	public function actionUpdate1()
	{
		$email = isset($_GET['val'])?$_GET['val']:null;
		// echo $email;die;
		$id = isset($_GET['id'])?$_GET['id']:null;
		// $email['email'] = $email;
		// echo $id;die;
		$model = new CompanyProfile;
		$info = $model::find()->where(['c_id'=>$id])->one();
		$info->email=$email;
		// $info->setAttributes($data);
		
		if($info->save())
		{
			echo 1;
		}
		else
		{
			echo '<pre>';
			print_r($info->errors);
		}
		
	}

	// 企业管理删除
	public function actionDel1()
	{
		//接收传送id
		$id = isset($_GET['id'])?$_GET['id']:null;
		$model = new CompanyProfile;
		$info = $model::find()->where(['c_id' => $id])->one()->delete();
		if($info)
		{
			$this->redirect(['/company/management']);
		}
		else
		{
			$this->redirect(['/company/management']);
		}
	}

	//企业会员
	public function actionCompanyadd()
	{
		return $this->render('companyadd.html');
	}

	//添加
	public function actionCompanyadd_pro()
	{
		$data = Yii::$app->request->post();
		$model = new CompanyProfile;
		$model->setAttributes($data);
		if($model->save())
		{
			echo "<script>alert('添加成功')</script>";
			return $this->redirect(['/company/companyadd']);
		}
		else
		{
			// echo '<pre>';
			// print_r($model->errors);
			echo "<script>alert('添加失败')</script>";
			return $this->redirect(['/company/companyadd']);
		}
	}


}

?>