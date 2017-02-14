<?php
use yii\helpers\Html;
?>
<p>You have entered the following information:</p>

<ul>
    <li><label>Name</label>: 
<?php  

	echo $model->name;
	// $db=Yii::$app->db;
	// $sql="select * from user where name='zhangsan' ";
	// $re=$db->createCommand($sql)->execute();
	// echo '<pre>';
	// print_r($re);

?></li>
</ul>