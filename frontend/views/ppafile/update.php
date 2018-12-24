<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Programs */

$this->title = 'แก้ไขไฟล์ : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'อัพโหลดไฟล์', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="programs-update">
    <div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
        <strong> <h4><?= Html::encode($this->title) ?></h4> ! </strong> กรุณาตรวจสอบไฟล์ก่อบบันทึกแก้ไขทุกครั้ง...
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
