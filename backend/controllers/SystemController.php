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
use app\models\Hotword;
use app\models\MembersLog;
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
    ////////热门关键词///////////////
    public function actionHotword(){//展示热门关键词方法
        header("content-type:text/html;charset=utf-8");
        $hotword=new hotword;//实例化
        //分页
        $query = $hotword::find();//拿数据
        //  print_r($query);die;
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => 9   //每页显示条数
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('hotword.html', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public  function actionHotedit(){//做修改
        $id=$_GET['id'];//拿要修改的id
        // print_r($id);
        $hotword=new hotword;//实例化数据库
        $data= $hotword::find()->where(['w_id'=>$id])->asArray()->one();//条件查询(其中asArrary将结果转换成数组)
        //print_r($data);die;
        return $this->renderPartial('hotedit.html',['data'=>$data]);//渲染模板
    }
    public  function actionHoteditdo(){//执行修改
        $hotword=new hotword;//实例化
        $getdata=$_POST;//接收表单提交数据
        //  print_r($getdata['w_id']);die;
        $data= $hotword::find()->where(['w_id'=>$getdata['w_id']])->one();//条件查询
        // print_r($data);
        $data->w_word=$getdata['w_word'];
        $data->w_hot=$getdata['w_hot'];
        $data->save();//保存
        return $this->redirect(['system/hotword']);//跳转至展示页面
    }
    public  function actionHotdel(){//执行删除
        $hotword=new hotword;//实例化
        $id=$_GET['id'];//拿要修改的id
        $data= $hotword::find()->where(['w_id'=>$id])->all();//条件查询
        // print_r($data);die;
        $data[0]->delete();
        return $this->redirect(['system/hotword']);//跳转至展示页面
    }
    public  function actionHotadd(){//添加
        return $this->renderPartial('hotadd.html');//渲染模板
    }
    public  function actionHotadddo(){//执行添加
        $w_word=$_POST['w_word'];
        // print_r($w_word);
        $hotword=new hotword;
        //增加数据
        $hotword->w_id='';
        $hotword->w_word=$w_word;
        //验证数据
        $hotword->validate();
        if($hotword->hasErrors()) {
            echo "数据有误";
            die;
        }
        $hotword->save();
        return $this->redirect(['system/hotword']);//跳转至展示页面
    }
    ////////日志///////////////
    public function actionMemberlog(){//展示会员日志
        header("content-type:text/html;charset=utf-8");
        $MembersLog=new MembersLog;//实例化
        $log_username=isset($_GET['email'])?$_GET['email']:null;//做个人简历点击对应本人日志
        if($getdata=$_GET){//做查询接值
            //  print_r($getdata);die;
            $where="1=1";//恒成立的
            if(!empty($getdata['log_utype'])){//如果会员类型不为空
                $log_utype=$getdata['log_utype'];
                $where.=" and log_utype='$log_utype'";
            }
            if(!empty($getdata['settr'])){//做选择几天内
                $settr=$getdata['settr'];//取到的天数
                $new=time()-$settr*86400;//几天前
                $where.=" and log_addtime>'$new'";
            }
            if(!empty($getdata['log_type'])){//如果日志类型不为空
                $log_type=$getdata['log_type'];
                $where.=" and log_type='$log_type'";
            }
//            if(!empty($log_username)){//如果有用户点击
//                $where.=" and log_username='$log_username'";
//            }
            $query = $MembersLog::find()->where($where);//拿数据
        };
        //分页
        if(empty($getdata)){//不查询接值
            if(empty($log_username)){
                $query = $MembersLog::find();//拿数据
            }else{//如果有用户点击
                $query = $MembersLog::find()->where("log_username='$log_username'");//拿数据
            }

        }
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => 2   //每页显示条数
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('memberlog.html', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public function actionMembersdel(){//会员日志批删
        $id=\yii::$app->request->get('id');
        $sql="delete from qs_members_log where log_id in ($id)";
        $a= \Yii::$app->db->createCommand($sql)->execute();
        if($a){
            echo "成功";
            return $this->redirect(['system/memberlog']);
        }else{
            echo "删出失败";
        }
    }
     //网站管理员
    public function actionManage(){


        $Admin=new Admin();//实例化
        //分页
        $query = $Admin::find();//拿数据
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => 5   //每页显示条数
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('manage_list.html', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
     public function actionManageadd(){
        return $this->renderPartial('manage_add.html');
    }
    //管理员入库操作
    public function actionManagedb(){
        $admin_name=isset($_POST['admin_name'])?$_POST['admin_name']:"";
        $email=isset($_POST['email'])?$_POST['email']:"";
        $pwd=md5(isset($_POST['pwd'])?$_POST['pwd']:"");
        $rank=isset($_POST['rank'])?$_POST['rank']:"";
        $admin=new Admin();
        $admin->admin_name=$admin_name;
        $admin->email=$email;
        $admin->pwd=$pwd;
        $admin->rank=$rank;
        if($admin->hasErrors()){
            echo 'data is error!';
            die;
        }
        $admin->save();
        return $this->redirect(['system/manage']);//跳转至展示页面
    }
     //管理员删除
    public function actionManage_del(){
        $admin_id=$_POST['admin_id'];
        $customer = Admin::findOne($admin_id);
        $customer->delete();
        if($customer){
            echo 1;
        }else{
            echo 0;
        }
    }
    //管理员密码修改表单页
    public function actionManage_update(){

        $admin_id=$_GET['id'];
        return $this->renderPartial('manage_update.html',['admin_id'=>$admin_id]);
    }
    //旧密码验证
    public function actionManage_orpwd(){
        $admin_id=$_POST['admin_id'];
        $admin_pwd=$_POST['admin_pwd'];
        $pwd = md5($admin_pwd);
        $sql="select pwd from qs_admin where admin_id=:id";
        $result= Admin::findBySql($sql,array(':id'=>$admin_id))->asArray()->all();
//        print_r($result);
        $pwd2=$result[0]['pwd'];
        if($pwd==$pwd2){
            echo 1;
        }else{
            echo 0;
        }
    }
    //管理密码修改操作
    public function actionManage_save(){
//        print_r($_POST);die;
        $admin_id=$_POST['admin_id'];
        $pwd=md5($_POST['pwd_c']);
        $admin_pwd=Admin::find()->where(['admin_id'=>$admin_id])->one();
        $admin_pwd->pwd=$pwd;
        $admin_pwd->save();
        return $this->redirect(['system/manage']);
    }
    //excel数据导出
    public function actionExcel_out(){
        $arr=Job::find()->asArray()->all();
        //获取要导出的数据
        $objPHPExcel=new \PHPExcel;
        // 实例化excel类
         $objPHPExcel->getProperties()
            ->setCreator('http://www.jb51.net')
            ->setLastModifiedBy('http://www.jb51.net')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('Document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Result file');
         //设置参数   
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','ID')
            ->setCellValue('B1','职位名称')
            ->setCellValue('C1','排序');
            //设置表头
        $i=2;
        foreach($arr as $k=>$v){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,$v['id'])
                ->setCellValue('B'.$i,$v['categoryname'])
                ->setCellValue('C'.$i,$v['category_order']);
            $i++;
        }
         //循环输出数据库中的信息  并放到对应的单元格中
        $objPHPExcel->getActiveSheet()->setTitle('招聘');
        //标题名称
        $objPHPExcel->setActiveSheetIndex(0);
        $filename=urldecode('职位列表').'_'.date('Y-m-dHis');
        //文件名称
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        // 生成xls文件
        header('Cache-Control: max-age=0');
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');   
        //若要生成xlsx文件   则要改为Excel2007
        $objWriter->save('php://output');
        return $this->redirect(['system/type']);
        // exit;
    }
	
}

?>