<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;

use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use yii\data\Pagination;

use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

// ลิงค์โมดูล dropdownlist
use frontend\models\Cyear;
use frontend\models\Province;
use frontend\models\District;
use frontend\models\Hospital;

//use miloschuman\highcharts\Highcharts;
//use kartik\form\ActiveForm;

/* @var $this yii\web\View */
$this->title = 'รายงานผลการบันทึกโครงการ P&P Area Based';
$this->params['breadcrumbs'][] = ['label' => 'ผลการบันทึกโครงการ P&P Area Based', 'url' => ['/report2/index']];
?>


<?php
$form = ActiveForm::begin([
    'validateOnSubmit' => true,
    // 'type' => ActiveForm::TYPE_HORIZONTAL,
    // 'fieldConfig' => ['autoPlaceholder' => true],
    // 'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_MEDIUM],
]);
?>

<div class="panel panel-success">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2">
                <?=$form->field($model, 'byear')->widget(Select2::classname(), [
                    'data' => Cyear::GetList(),
                    'options' => ['placeholder' => '--- เลือกปี ---'],
                    'pluginOptions' => [
                        // 'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-2">
                <?=$form->field($model, 'province')->dropdownList(ArrayHelper::map(Province::find()->all(), 'changwatcode', 'changwatname'), [
                    'id' => 'ddl-province',
                    'prompt' => '--- เลือกจังหวัด ---',
                ]);
                ?>
            </div> 
            <div class="col-md-3">
                <?=$form->field($model, 'district')->widget(DepDrop::classname(), [
                  'options' => ['id' => 'ddl-amphur'],
                  'data' => [],
                  //'data' => $district,
                  'type' => DepDrop::TYPE_SELECT2,
                  'pluginOptions' => [
                      'depends' => ['ddl-province'],
                      'placeholder' => '--- เลือกอำเภอ/เขต ---',
                      'url' => Url::to(['/report2/get-amphur'])
                  ]
                ]);
                    ?>
            </div>
            <div class="col-md-5">
                <?=$form->field($model, 'hospital')->widget(DepDrop::classname(), [
                    'data' => [],
                    //'data' => $hospital,
                    'type' => DepDrop::TYPE_SELECT2,
                    'pluginOptions' => [
                        'depends' => ['ddl-province', 'ddl-amphur'],
                        'placeholder' => '--- เลือกหน่วยบริการ ---',
                        'url' => Url::to(['/report2/get-hospital'])
                    ]
                ]);
                ?>
            </div>
        </div>          
<!--end row-->
        <div class="row">
            <div class="col-md-12" style="text-align: right;">
                <div class="form-group">
                    <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> ค้นหา', ['class' => 'btn btn-info btn-flat']) ?>
                </div>
            </div>
        </div>   
<!--end row-->
    </div>
<?php ActiveForm::end();?>
</div> 

<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'headerRowOptions' => ['style' => 'background-color:#cccccc'],
    'responsive' => true,
    'hover' => true,
    'pjax' => true,
    'pjaxSettings' => [
        'neverTimeout' => true,
        'beforeGrid' => '',
        'afterGrid' => '',
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'byear',
            'header' => 'ปี',
        ],
        [
            'attribute' => 'hoscode',
			'format'=>'text', 
            'header' => 'HCODE',
        ],
        [
            'attribute' => 'IDPROJECT',
            'header' => 'รหัสโครงการ',
        ], 
        [
            'attribute' => 'NAMEPROJECT',
            'label' => 'ชื่อโครงการ',
            'format' => 'raw',
            'contentOptions' => [
                'style'=>'max-width:1000px; overflow: auto; white-space: normal; word-wrap: break-word;'
            ], 
        ], 
        [
            'attribute' => 'result',
            'header' => 'ผลงาน',
        ],
        [
            'attribute' => 'd_com',
            'header' => 'วันที่ประมวลผล',
        ]

    ],
]);
?>


<?= \bluezed\scrollTop\ScrollTop::widget() ?>

