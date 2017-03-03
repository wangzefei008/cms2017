<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use app\models\Resume;
use backend\models\Members;
use yii\data\Pagination;
class PersonController extends Mycontroller
{
    //////////////个人简历///////////////////
    public function actionResumelist(){//展示个人简历
        $resume=new resume;
        if($getdata=$_GET){//做查询接值(此处为Get是为了做搜索后分页)
            //  print_r($getdata);die;
            $where="1=1";//恒成立的
            if(!empty($getdata['talent'])){//如果简历等级不为空
                $talent=$getdata['talent'];
                $where.=" and talent='$talent'";
            }
            if(!empty($getdata['photo_display'])){//如果照片可见
                $photo_display=$getdata['photo_display'];
                $where.=" and photo_display='$photo_display'";
            }
            if(!empty($getdata['photo_audit'])){//如果照片审核
                $photo_audit=$getdata['photo_audit'];
                $where.=" and photo_audit='$photo_audit'";
            }
            if(!empty($getdata['settr'])){//做选择几天内
                $settr=$getdata['settr'];//取到的天数
                $new=time()-$settr*86400;//几天前
                $where.=" and addtime>'$new'";
            }

            $query = $resume::find()->where($where);//拿数据
        };
        //分页
        if(empty($getdata)){
            $query = $resume::find();//拿简历数据
        }
        //print_r($query);die;
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => 9   //每页显示条数
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('resumelist.html', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public function actionResumedel(){//删除简历
        $resume=new resume;//实例化
        $id=$_GET['id'];//拿要修改的id
        $data= $resume::find()->where(['id'=>$id])->all();//条件查询
        // print_r($data);die;
        $data[0]->delete();
        return $this->redirect(['person/resumelist']);//跳转至展示页面
    }
    public function actionResumeedit(){//修改简历
        $resume=new resume;//实例化
        $id=$_GET['id'];//拿要修改的id
        $data= $resume::find()->where(['id'=>$id])->asArray()->one();//条件查询
       // print_r($data);
        return $this->render('resumeedit.html',['data'=>$data]);//渲染数据
    }
    public function actionResumeeditdo(){//执行修改
        $resume=new resume;//实例化
        $getdata=$_POST;//接收简历审核提交数据
      //  print_r($getdata);
        $data=$resume::find()->where(['id'=>$getdata['id']])->one();
        $data->audit=$getdata['audit'];
        $data->talent=$getdata['talent'];
        $data->photo_audit=$getdata['photo_audit'];
        $data->save();
        return $this->redirect(['person/resumelist']);//跳转至展示页面
    }
    //////////////个人会员///////////////////
    public function actionMemberslist(){//个人会员展示方法
        $members=new members;
        $where="utype=2";//个人的会员
        $getdata=$_GET;
        if($getdata!==""){//做查询接值
            //  print_r($getdata);die;
            if(@$getdata['email_audit']!==""){//如果邮箱验证不为空
               @$email_audit=$getdata['email_audit'];
                @$where.=" and email_audit='$email_audit'";
            }
            if(@$getdata['mobile_audit']!==""){//如果手机验证
                @$mobile_audit=$getdata['mobile_audit'];
                @$where.=" and mobile_audit='$mobile_audit'";
            }
            if(@$getdata['settr']!==""){//做选择几天内
                @$settr=$getdata['settr'];//取到的天数
                @$new=time()-$settr*86400;//几天前
                @$where.=" and reg_time>'$new'";
            }
            $query = $members::find()->where($where);//拿数据
        }else{
            $query = $members::find()->where($where);//拿个人会员数据
        };
        //分页
        //print_r($query);die;
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => 2   //每页显示条数
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('memberslist.html', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public function actionMembersdel(){//个人会员批删
        $id=\yii::$app->request->get('id');
        $sql="delete from qs_members where uid in ($id)";
        $a= \Yii::$app->db->createCommand($sql)->execute();
        if($a){
            return $this->redirect(['person/memberslist']);
        }else{
            echo "删出失败";
        }
    }
    public  function actionMembersadd(){//个人会员添加
        return $this->renderPartial('memberadd.html');//渲染模板
    }
    public  function actionMembersadddo(){//执行个人会员添加
        $data=$_POST;
        // print_r($ip = $_SERVER["REMOTE_ADDR"]);die;
        $members=new members;
        //增加数据
        $members->uid='';
        $members->utype='2';//个人会员
        $members->reg_time=time();//注册时间
        $members->reg_ip=$ip = $_SERVER["REMOTE_ADDR"];//注册ip
        $members->username=$data['username'];
        $members->mobile=$data['mobile'];
        $members->email=$data['email'];
        $members->password=md5($data['password']);
        //验证数据
        $members->validate();
        if($members->hasErrors()) {
            echo "数据有误";
            die;
        }
        $members->save();
        return $this->redirect(['person/memberslist']);
    }
    public function actionMembersedit(){//个人会员修改
        $members=new members;
        $uid=$_GET['id'];
       // print_r($uid);
        $data=$members::find()->where(['uid'=>$uid])->asArray()->one();
        return $this->render("membersedit.html",["data"=>$data]);
    }
    public function actionMemberseditdo(){//执行会员修改
        $members=new members;
        $getdata=$_POST;//接收数据
        $data=$members::find()->where(["uid"=>$getdata['id']])->one();
        $data->username=$getdata['username'];
        $data->email=$getdata['email'];
        $data->mobile=$getdata['mobile'];
        $data->password=md5($getdata['password']);
        $data->save();
        return $this->redirect(['person/memberslist']);
    }

}