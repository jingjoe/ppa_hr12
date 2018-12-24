<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SysSetTime */

$this->title = 'ตั้งวันที่เวลา';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งวันที่เวลา', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-set-time-create">
    <div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
        <strong> <h4><?= Html::encode($this->title) ?></h4> ! </strong> กรุณาตรวจสอบไฟล์ก่อบบันทึกแก้ไขทุกครั้ง...
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
