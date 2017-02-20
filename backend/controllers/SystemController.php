<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Admin;
use backend\models\NewCaptcha;
use backend\models\Filter;
use backend\models\FilterIp;
use app\models\Config;
use app\models\UploadForm;
use app\models\Area;
use app\models\Job;
use app\models\Major;
use app\models\Group;
use app\models\Category;
use yii\data\Pagination;
use yii\web\UploadedFile;

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

	//网站配置
	public function actionConfig()
	{
		$result=Config::find()->where(['id'=>1])->asArray()->one();
		$model=new UploadForm;
		return $this->renderpartial('config.html',['result'=>$result,'model'=>$model]);
	}
	//网站配置修改
	public function actionConfig_do()
	{
		$arr=Yii::$app->request->post();
		// print_r($arr);die;
		unset($arr['UploadForm']);
		$model = new UploadForm();
        $imginfo=$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
        // print_r($imginfo);die;
        $img_name=$imginfo[0]->name;
        $img_path='uploads/'.$img_name;
        $aa=$model->upload();
        // print_r($aa);die;
        if($aa){
        	$arr['w_logo']=$img_path;
        }	
         $result=Config::find()->where(['id'=>1])->one();
		 $result->setAttributes($arr);
		 $result->save();
		 return $this->redirect(['/system/config']);	
	}
	//分类管理 首页
	public function actionType()
	{
		$arr1=Area::find()->asArray()->all();
		$arr2=Job::find()->asArray()->all();
		$arr3=Major::find()->asArray()->all();
		$arr4=Group::find()->asArray()->all();
		$res1=$this->tree($arr1);
		$res2=$this->tree1($arr2);
		$res3=$this->tree2($arr3);
		// print_r($arr4);die;
		return $this->renderpartial('type.html',['arr1'=>$res1,'arr2'=>$res2,'arr3'=>$res3,'arr4'=>$arr4]);
	}
	 //无限极 递归实现
    // 相当于将表中的数据重新排序 分类
    public function tree($res,$parent_id=0,$leave=0){    	
        static $tree=array();
        //定义静态变量 可重复加值
        foreach($res as $key=>$val){
            if($val['parentid']==$parent_id){
                $val['leave']=$leave;
                $tree[]=$val;
                $this->tree($res,$val['id'],$leave+1);
            }
        }
        return $tree;
    }
    public function tree1($res,$parent_id=0,$leave=0){    	
        static $tree1=array();
        //定义静态变量 可重复加值
        foreach($res as $key=>$val){
            if($val['parentid']==$parent_id){
                $val['leave']=$leave;
                $tree1[]=$val;
                $this->tree1($res,$val['id'],$leave+1);
            }
        }
        return $tree1;
    }
    public function tree2($res,$parent_id=0,$leave=0){    	
        static $tree2=array();
        //定义静态变量 可重复加值
        foreach($res as $key=>$val){
            if($val['parentid']==$parent_id){
                $val['leave']=$leave;
                $tree2[]=$val;
                $this->tree2($res,$val['id'],$leave+1);
            }
        }
        return $tree2;
    }
    //删除分类  子类也删除
	public function actionDel(){
		$type=$_POST['type'];
		$id=$_POST['id'];
		if($type==1){
			$res=Area::find()->asArray()->all();
	        $list=$this->tree($res,$id);
			//递归 得到父ID为cat_id的所有数据
	        foreach($list as $key=>$val){
	            $ids[]=$val['id'];
	        }
	        $ids[]=$id;
	        //将上一级元素也添加进去 进行批删
	        $str=implode(',', $ids);
	        // echo $str;
	        $res=Area::deleteall('id in('.$str.')');	        
		}elseif ($type==2) {
			$res=Job::find()->asArray()->all();
	        $list=$this->tree($res,$id);
			//递归 得到父ID为cat_id的所有数据
	        foreach($list as $key=>$val){
	            $ids[]=$val['id'];
	        }
	        $ids[]=$id;
	        //将上一级元素也添加进去 进行批删
	        $str=implode(',', $ids);
	        // echo $str;
	        $res=Area::deleteall('id in('.$str.')');
		}else{
			$res=Major::find()->asArray()->all();
	        $list=$this->tree($res,$id);
			//递归 得到父ID为cat_id的所有数据
	        foreach($list as $key=>$val){
	            $ids[]=$val['id'];
	        }
	        $ids[]=$id;
	        //将上一级元素也添加进去 进行批删
	        $str=implode(',', $ids);
	        // echo $str;
	        $res=Area::deleteall('id in('.$str.')');
		}
		if($res){
	             $map['error']=1;
	             $map['id']=$ids;
	        }else{
	            $map['error']=0;
	        }
	           echo json_encode($map);
	}
	//批量删除
	public function actionDel_all(){
		$type=$_POST['type'];
		$ids=$_POST['ids'];
		if($type==1){
	        $res=Area::deleteall('id in('.$ids.')');	        
		}elseif ($type==2) {
			$res=Job::deleteall('id in('.$ids.')');
		}else{
			$res=Major::deleteall('id in('.$ids.')');
		}
		if($res){
	             $map['error']=1;
	             $map['id']=explode(',',$ids);
	        }else{
	            $map['error']=0;
	        }
	           echo json_encode($map);
	}
	//添加分类
	public function actionAdd_top(){
		$type=$_GET['type'];
		$parentid=isset($_GET['parentid'])?$_GET['parentid']:'0';
		if($type==1){
			$res=Area::find()->asArray()->all();
		}elseif($type==2){
			$res=Job::find()->asArray()->all();
		}else{
			$res=Major::find()->asArray()->all();
		}		
		return $this->render('add_top.html',['res'=>$res,'parentid'=>$parentid,'type'=>$type]);
	}
	//添加分类入库
	public function actionAdd_top_do(){
		$type=$_GET['type'];
		$arr=Yii::$app->request->post();
		if($type==1){
			$res=new Area();
		}elseif($type==2){
			$res=new Job();
		}else{
			$res=new Major();
		}	
		$res->setAttributes($arr);
		if($res->save()){
			return $this->redirect(['/system/type']);
		}
	}
	//修改分类
	public function actionUpdate_top(){
		$type=$_GET['type'];
		$id=$_GET['id'];
		if($type==1){
			$res=Area::find()->where(['id'=>$id])->asArray()->one();
			$res1=Area::find()->asArray()->all();
		}elseif($type==2){
			$res=Job::find()->where(['id'=>$id])->asArray()->one();
			$res1=Job::find()->asArray()->all();
		}else{
			$res=Major::find()->where(['id'=>$id])->asArray()->one();
			$res1=Major::find()->asArray()->all();
		}		
		return $this->render('update_top.html',['res'=>$res,'res1'=>$res1,'type'=>$type]);
	}
	//修改分类入库
	public function actionUpdate_top_do(){
		$type=$_GET['type'];
		$id=$_GET['id'];
		$arr=Yii::$app->request->post();
		if($type==1){
			$res=new Area();
		}elseif($type==2){
			$res=new Job();
		}else{
			$res=new Major();			
		}
		$res1=$res::find()->where(['id'=>$id])->one();
		// print_r($res1);die;
		$res1->setAttributes($arr);	
		if($res1->save()){
			return $this->redirect(['/system/type']);
		}
	}
	//查看其它分类的子分类
	public function actionShow_type(){
		$g_alias=$_GET['g_alias'];
		$g_name=$_GET['g_name'];
		$res=Category::find()->where(['c_alias'=>$g_alias])->asArray()->all();
		return $this->render('show_type.html',['res'=>$res,'g_name'=>$g_name]);
	}
	public function actionDel_type(){
		$ids=$_POST['ids'];
		$res=Category::deleteall('c_id in('.$ids.')');	        
		if($res){
		    $map['error']=1;
		    $map['id']=explode(',',$ids);
		}else{
		    $map['error']=0;
		}
		    echo json_encode($map);
	}
	public function actionUpdate_name(){
		$c_id=$_POST['c_id'];
		$c_name=$_POST['c_name'];
		$res=Category::find()->where(['c_id'=>$c_id])->one();
		// print_r($res);
		$res->c_name=$c_name;
		if($res->save()){
			echo 1;
		}else{
			echo 0;
		}
	}
	
}

?>