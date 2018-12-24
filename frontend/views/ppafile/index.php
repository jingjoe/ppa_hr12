<?php

use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\Alert;
use yii\widgets\Pjax;
use yii\helpers\Url;

use yii\bootstrap\Modal;

use  yii\web\Session;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'อัพโหลดไฟล์';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ppafile-index">
    <?php
        if (Yii::$app->session->hasFlash('alert')) {

            echo Alert::widget([
                'type' => Alert::TYPE_SUCCESS,
                //'icon' => 'glyphicon glyphicon-info-sign',
                //'title' => 'สถานะการบันทึกข้อมูล!',
                //'titleOptions' => [ 'icon' => 'info-sign'],
                'body' => Yii::$app->session->getFlash('alert'),
                'showSeparator' => true,
                'delay' => 1500
            ]);
        }
    ?>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-upload""></span> อัพโหลดไฟล์', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

        <?=  GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'panel' => ['type' => 'success', 'heading' => 'ไฟล์'],
            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
            'hover' => true,
            'striped' => false,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'detail:ntext',
            'files:ntext',
            'create_date',
            //'modify_date',
            'loginname',
            //'updatename',
            'hits',

            //['class' => 'yii\grid\ActionColumn'],
   
            [
                'class' => 'yii\grid\ActionColumn',
                //'buttonOptions'=>['class'=>'btn btn-default'],
                'template'=>'{update} {delete}',
                //'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 3,
                'buttons'=>[
                   'update'=>function ($url, $model,$key) {
                        $t = 'index.php?r=ppafile/update&id='.$model->id;
                        return  Yii::$app->user->id == $model->created_by ? Html::a('<i class="glyphicon glyphicon-pencil"></i>',$url) : null;
                    },
                    'delete'=>function ($url, $model,$key) {
                        $t = 'index.php?r=ppafile/delete&id='.$model->id;
                        return Yii::$app->user->id == $model->created_by ? Html::a('<i class="glyphicon glyphicon-trash"></i>',$url) : null;
                    },
                  ]
            ],
        ],
    ]); ?>

</div>
<font color="#ff0040"><p>* หมายเหตุ </font>ถ้าคุณไม่ใช่เจ้าของไฟล์จะไม่สามารถลบหรือแก้ไขไฟล์ได้ !</p>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>