<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;

$this->title = 'ผลให้บริการสร้างเสริมสุขภาพและป้องกันโรค(P&P Area Based) ปี 2562 แยกตามโครงการ';
$this->params['breadcrumbs'][] = ['label' => 'รายงานผลการบันทึกโครงการ (P&P Area Based) ปี 2562', 'url' => ['report2/index']];
$this->params['breadcrumbs'][] = ['label' => 'รายงานผลการบันทึกโครงการ (P&P Area Based) ปี 2562 แยกตามโครงการ', 'url' => ['/report2/rep04']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<?php foreach ($ppaname as $ppa) { ?>
<?php } ?> 

<?php foreach ($ppacom as $com) { ?>
<?php } ?> 


<div class="panel panel-default">
    <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span>  โครงการ  <?php echo $ppa['ppaname']; ?> </h3> </div>
  <div class="panel-body">
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
                   GridView::EXCEL=> ['label' => 'ส่งออกไฟล์ excel', 'filename' => 'ppa2562_'. $pacode.'_'.date('Y-d-m')],
                ],
        // set your toolbar
            'toolbar' =>  [
                ['content' => 
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['detail3','pacode'=>$pacode], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
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
                [
                    'class' => 'kartik\grid\SerialColumn'
                ],
                [
                    'attribute' => 'byear',
                    'header' => 'PPA ปี',
                ],
                [
                    'attribute' => 'hoscode',
                    'format'=>'text', 
                    'header' => 'HOSCODE'
                ],
                [
                    'attribute' => 'hosname',
                    'header' => 'ชื่อหน่วยบริการ',
                    'width' => '70%',
                ],
                [
                    'attribute' => 'result',
                    'header' => 'ผลงาน'
                ],
            ]
        ]);
        ?>
      
      
  </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-right">
            <span class="glyphicon glyphicon-time"></span> วันที่ประมวลผล <?php echo $com['d_com']; ?> น.
        </div>
    </div>
</div>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>