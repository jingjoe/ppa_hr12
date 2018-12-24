<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SysSetTime */

$this->title = ''. ' '.'วันที่ : ' . ' ' . $model->date. ' '.'เวลา : ' . ' ' . $model->time;
$this->params['breadcrumbs'][] = ['label' => 'ตั้งวันที่เวลา', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-set-time-view">

    <div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
        <strong> <h4><?= Html::encode($this->title) ?></h4> ! </strong> กรุณาตรวจสอบไฟล์ก่อบบันทึกแก้ไขทุกครั้ง...
    </div>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'date',
            'time',
            'days'
        ],
    ]) ?>

</div>
