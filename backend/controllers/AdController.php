<?php
namespace backend\controllers;
header('content-type:text/html;charset=utf8');
use Yii;
use yii\web\Controller;
use app\models\Ad;
use app\models\Adcate;
use yii\data\Pagination;
use yii\helpers\Url;

class AdController extends MyController
{
	//禁用csrf   yii  ajax  400
    public function init(){
    	$this->enableCsrfValidation = false;
	}
	//广告管理 首页 加搜索后分页
	public function actionIndex(){
		$deadline=isset($_GET['d_time'])?$_GET['d_time']:'';
		$is_display=isset($_GET['status'])?$_GET['status']:'';
		$category_id=isset($_GET['cate'])?$_GET['cate']:'';
		$where='1=1';
		// echo $is_display;die;
		if(!empty($deadline)||!empty($is_display)||!empty($category_id)){
			if($deadline!=0){
				$time=time();
				if($deadline==1){
					$where.=" and deadline<=$time";
				}else{
					$aa=$time+$deadline;
					$where.=" and deadline<=$aa";
				}
			}
			if($is_display!=0){
				$where.=" and is_display=$is_display";
			} 
			if($category_id!=0){
				$where.=" and category_id=$category_id";
			}
		}
		// echo $where;die;
		$arr=Ad::find()->select('*')
		->join('JOIN','qs_ad_category as c','qs_ad.category_id=c.c_id')
		->join('JOIN','qs_type as t','qs_ad.type_id=t.t_id')->where($where);
		$pages = new Pagination([
			'totalCount' => $arr->count(),
			'pageSize'   => 3   //每页显示条数
		]);
		$res1 = $arr->offset($pages->offset)
		->limit($pages->limit)
		->asArray()->all();
		// print_r($res1);die;
		$res2=Adcate::find()->asArray()->all();
		return $this->render('ad.html',['res1'=>$res1,'res2'=>$res2,'pages'=>$pages]);
	}
	//删除广告
	public function actionDel_all(){
		$ids=$_GET['ids'];
		$res=Ad::deleteall('id in('.$ids.')');	        
		if($res){
			echo 1;
		    return $this->redirect(['/ad/index']);
		}else{
			echo 0;
			return $this->redirect(['/ad/index']);
		}
	}
	//删除广告位
	public function actionDel_all1(){
		$ids=$_GET['ids'];
		$res=Adcate::deleteall('c_id in('.$ids.')');	        
		if($res){
			echo 1;
		    return $this->redirect(['/ad/index']);
		}else{
			echo 0;
			return $this->redirect(['/ad/index']);
		}
	}
	//添加广告
	public function actionAdd_ad_do(){
		$arr=Yii::$app->request->post();
		$arr['starttime']=strtotime($arr['starttime']);
		$arr['deadline']=strtotime($arr['deadline']);
		$arr['type_id']=1;
		$arr['addtime']=time();
		$arr['alias']='QS_indexfocus';
		// print_r($arr);die;
		$ad=new Ad;
		$ad->setAttributes($arr);
		if($ad->save()){
			return $this->redirect(['/ad/index']);
		}else{
			echo "<script>alert('添加失败')</script>";
		}
	}
	//修改广告
	public function actionUpdate_ad(){
		$id=$_GET['id'];
		$res=Ad::find()->where(['id'=>$id])->asArray()->one();
		$res['starttime']=date('Y-m-d',$res['starttime']);
		$res['deadline']=date('Y-m-d',$res['deadline']);
		$res1=Adcate::find()->asArray()->all();
		// print_r($res1);die;
		return  $this->renderpartial('update_ad.html',['res'=>$res,'res1'=>$res1]);
	}
	//修改广告 入库
	public function actionUpdate_ad_do(){
		$id=$_GET['id'];
		$arr=Yii::$app->request->post();
		$res=Ad::find()->where(['id'=>$id])->one();
		$arr['starttime']=strtotime($arr['starttime']);
		$arr['deadline']=strtotime($arr['deadline']);
		$arr['type_id']=1;
		$arr['addtime']=time();
		$arr['alias']='QS_indexfocus';
		$res->setAttributes($arr);
		$res->save();
		return $this->redirect(['/ad/index']);
	}
	//添加广告位
	public function actionAdd_adcate(){
		return $this->renderpartial('add_adcate.html');
	}
	//添加广告位  入库
	public function actionAdd_adcate_do(){
		$arr=Yii::$app->request->post();
		$adcate=new Adcate;
		$adcate->setAttributes($arr);
		$adcate->save();
		return $this->redirect(['/ad/index']);
	}
	//修改广告位
	public function actionUpdate_adcate(){
		$id=$_GET['id'];
		$res=Adcate::find()->where(['c_id'=>$id])->asArray()->one();
		return  $this->renderpartial('update_adcate.html',['res'=>$res]);
	}
	//修改广告位入库
	public function actionUpdate_adcate_do(){
		$id=$_GET['id'];
		$arr=Yii::$app->request->post();
		$res=Adcate::find()->where(['c_id'=>$id])->one();
		$res->setAttributes($arr);
		$res->save();
		return $this->redirect(['/ad/index']);
	}
}