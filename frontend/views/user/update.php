<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'ปรับปรุงข้อมูล : ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้งานระบบ', 'url' => ['index']];
?>

<div class="user-update">
 
    <div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
        <strong> <h4><?= Html::encode($this->title) ?></h4> ! </strong> กรุณาตรวจสอบข้อมูลก่อบบันทึกหรือแก้ไขทุกครั้ง...
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 
