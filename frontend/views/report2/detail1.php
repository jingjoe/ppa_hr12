<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;

$this->title = 'ผลให้บริการสร้างเสริมสุขภาพและป้องกันโรค(P&P Area Based)แยกตามโครงการ';
$this->params['breadcrumbs'][] = ['label' => 'รายงานผลการบันทึกโครงการ (P&P Area Based)', 'url' => ['report2/index']];
$this->params['breadcrumbs'][] = ['label' => 'Go Back', 'url' => ['/report2/rep01','byear' => $byear,'pacode' => $pacode]];
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
                   GridView::EXCEL=> ['label' => 'ส่งออกไฟล์ excel', 'filename' => 'year'. $byear.'_'.'ppa'. $pacode.'_'.date('Y-d-m')],
                ],
        // set your toolbar
            'toolbar' =>  [
                ['content' => 
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['detail1','byear' => $byear,'pacode'=>$pacode], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
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
                    'header' => 'ปี',
                ],
                [
                    'attribute' => 'hoscode',
                    'format'=>'text', 
                    'header' => 'รหัสหน่วยบริการ'
                ],
                [
                    'attribute' => 'hosname',
                    'header' => 'ชื่อหน่วยบริการ',
                    'width' => '60%',
                ],
                [
                    'attribute' => 'result',
                    'header' => 'ผลงาน'
                ],
                [
                    'attribute' => 'd_com',
                    'header' => 'วันที่ประมวลผล'
                ],
            ]
        ]);
        ?>
      
      
  </div>
</div>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>