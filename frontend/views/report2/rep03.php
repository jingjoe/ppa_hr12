<?php
//use miloschuman\highcharts\Highcharts;

use yii\helpers\Html;
//use kartik\form\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use yii\data\Pagination;

/* @var $this yii\web\View */
$this->title = 'รายงานผลการบันทึกโครงการ P&P Area Based ปี 2561 ทั้งหมด';
$this->params['breadcrumbs'][] = ['label' => 'รายงานผลการบันทึกโครงการ P&P Area Based ปี 2561', 'url' => ['/report2/index']];
?>


<!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><span class="glyphicon glyphicon-object-align-bottom"></span> <?= Html::encode($this->title) ?></h3>
            </div>
           
      <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'headerRowOptions' => ['style' => 'background-color:#cccccc'],
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                //'heading' => '<h3 class="panel-title"><i class="fa fa-file-excel-o"></i>ชื่อไฟล์ </h3>',
                //'after' => 'วันที่ประมวลผล '.date('Y-m-d H:i:s').' น.',
                'footer'=>false
            ],
            'responsive' => true,
            'hover' => true,
            'autoXlFormat'=>true,
            'exportConfig' => [
                   GridView::EXCEL=> ['label' => 'ส่งออกไฟล์ excel', 'filename' => 'ppa2561all_'.date('Y-d-m')],
                ],
        // set your toolbar
            'toolbar' =>  [
                ['content' => 
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['rep03'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
                ],
                '{toggleData}',
                '{export}',
            ],
        // set export properties
            'export' => [
		'showConfirmAlert'=>false,
                'fontAwesome' => false
            ],
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
                    'header' => 'รหัสหน่วยบริการ',
                    'contentOptions' => [
                        'style'=>'max-width:100px;'
                    ],
                ],
                [
                    'attribute' => 'hosname',
                    'header' => 'ชื่อหน่วยบริการ',
                    'contentOptions' => [
                        'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],
                [
                    'attribute' => 'IDPROJECT',
                    'header' => 'รหัสโครงการ',
                    'contentOptions' => [
                        'style'=>'max-width:100px;'
                    ],
                ],
                [
                    'attribute' => 'NAMEPROJECT',
                    'header' => 'ชื่อโครงการ',
                    'contentOptions' => [
                        'style'=>'max-width:400px; overflow: auto; white-space: normal; word-wrap: break-word;'
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
    </div>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>
