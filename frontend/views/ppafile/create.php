<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Programs */

$this->title = 'อัพโหลดไฟล์';
//$this->params['breadcrumbs'][] = ['label' => 'โปรแกรม', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programs-create">
    <div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
        <strong> <h4><?= Html::encode($this->title) ?></h4></strong> <font color="#ff0040"><p>* การตั้งชื่อไฟล์ </font> แนะนำให้ตั้งชื่อภาษาอักฤษ ตัวอย่างชื่อไฟล์ (ppa2561_XX.นามสกุล xls หรือ xlsx) xx คือรหัสจังหวัด provcode</p>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
