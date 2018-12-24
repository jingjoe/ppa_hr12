<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


// add upload
use yii\helpers\Url;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\FileInput;
use yii\helpers\VarDumper;

?>

<div class="programs-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>
  <div class="row">
        <div class="col-md-12 col-xs-12">
            <?=
            $form->field($model, 'files')->widget(FileInput::classname(), [
                //'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'initialPreview' => empty($model->files) ? [] : [
                        Yii::getAlias('@web') . '/sqlscript/' . $model->files,
                            ],
                    'allowedFileExtensions' => ['zip','rar','xls','xlsx'],
                    'showPreview' => false,
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false
                ]
            ]);
            ?>
            <p class="help-block">รองรับนามสกุล zip,rar,xls,xlsx ขนาดไฟล์ไม่เกิน 10 Mb</p>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-upload"></i> ' . ($model->isNewRecord ? 'อัพโหลด' : 'แก้ไข'), ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary') . ' btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
