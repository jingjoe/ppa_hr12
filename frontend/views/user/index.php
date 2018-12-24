<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ผู้ใช้งานระบบ';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่าระบบ', 'url' => ['/setting/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
   <div class="box">
   <div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
        <strong> <h4><?= Html::encode($this->title) ?></h4> ! </strong> กรุณาตรวจสอบข้อมูลก่อบบันทึกหรือแก้ไขทุกครั้ง...
    </div>
        <div class="box-body">
      <?php Pjax::begin(); ?>  
    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        'full_name',
        'cid',
        'hospcode',
        'username',
        //'auth_key',
        //['attribute'=>'password_hash','label'=>'รหัสผ่าน'],
        //'password_reset_token',
        'email',
        //'user_role.role_id',
        [
            'attribute' => 'role',
            'value' => function($data) {
                if (isset($data->user_role->role_desc)) {
                    return $data->user_role->role_desc;
                } else {
                    return 'ไม่ทราบสิทธิ'; //
                }
            },
            'filter' => \yii\helpers\ArrayHelper::map(frontend\models\UserRole::find()->all(), 'role_name', 'role_desc'),
        ],
        //'status',
        [
            'attribute' => 'status',
            'value' => function($data) {
                if (isset($data->user_status->status_desc)) {
                    return $data->user_status->status_desc;
                } else {
                    return 'ไม่ทราบสิทธิ'; //
                }
            },
            'filter' => \yii\helpers\ArrayHelper::map(frontend\models\UserStatus::find()->all(), 'status_name', 'status_desc'),
        ],
        'created_at',
        'updated_at',
        ['class' => 'yii\grid\ActionColumn', 
                'template' => '{view}<span class="glyphicon glyphicon-option-vertical"></span>{update}<span class="glyphicon glyphicon-option-vertical"></span>{delete}'
        ]
    ];   
    echo  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            //'type' => GridView::TYPE_SUCCESS,
            //'type' => 'success',
            //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> เพิ่มผู้ใช้งานระบบ', ['create'], ['class' => 'btn btn-success']),
        ],
        'responsive' => true,
        'hover' => true,
       // 'floatHeader' => true,
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'beforeGrid' => '',
            'afterGrid' => '',
        ],
        'columns' => $columns
    ]);
    ?>
   <?php Pjax::end(); ?>
        </div>
    </div>
  
</div>
   <?= \bluezed\scrollTop\ScrollTop::widget() ?>