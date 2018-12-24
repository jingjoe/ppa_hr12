<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\UserRole;
use frontend\models\UserStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'full_name')->textInput(['maxlength' => 255]) ?>
    
    <?= $form->field($model, 'cid')->textInput(['maxlength' => 13]) ?>
    
    <?= $form->field($model, 'hospcode')->textInput(['maxlength' => 5]) ?>
    
    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'role')->dropDownList(ArrayHelper::map(UserRole::find()->all(), 'role_id', 'role_desc')); ?>

    <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(UserStatus::find()->all(), 'status_id', 'status_desc')); ?>

    <div class="form-group pull-right">
        <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-save"></i> ' . ($model->isNewRecord ? 'บันทึก' : 'แก้ไข'), ['class' => ($model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-warning btn-flat')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
