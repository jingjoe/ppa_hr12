<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use kartik\grid\GridView;

use miloschuman\highcharts\Highcharts;

$this->title = 'ผลการการบันทึกโครงการ P&P Area Based';
$this->params['breadcrumbs'][] = ['label' => 'ผลการการบันทึกโครงการ P&P Area Based', 'url' => ['site/index']];
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="panel panel-default">
    <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span> ผลการประเมินโอกาสเสี่ยงต่อการเกิดโรคหัวใจและหลอดเลือด (CVD Risk) การเปลี่ยน SCORE ลดลง ปี <?php echo $cyear; ?></h3> </div>
    <div class="panel-body">


    <?=GridView::widget([
            'dataProvider' => $dataProvider,
            //'showPageSummary'=>true,
            'headerRowOptions' => ['style' => 'background-color:#cccccc'],
            'beforeHeader'=>[
                [
                    'columns'=>[
                        ['content'=>'', 'options'=>['colspan'=>3, 'class'=>'text-center default']],
                        ['content'=>'ผลการประเมินโอกาสเสี่ยงปี 2561', 'options'=>['colspan'=>7, 'class'=>'text-center warning']], 
                        ['content'=>'ผลการประเมินโอกาสเสี่ยงปี 2562', 'options'=>['colspan'=>7, 'class'=>'text-center warning']], 
                    ],
                    'options'=>['class'=>'skip-export'] // remove this row from export
                ]
            ],
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                //'after' => 'วันที่ประมวลผล '.date('Y-m-d H:i:s').' น.',
                'footer'=>false
            ],
            'responsive' => true,
            'hover' => true,
	    'autoXlFormat'=>true,
            'exportConfig' => [
                   GridView::EXCEL=> ['label' => 'ส่งออกไฟล์ excel', 'filename' => 'cvdrisk02'.date('Y-d-m')],
            ],
        // set your toolbar
            'toolbar' =>  [
                ['content' => 
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['cvdrisk02', 'cyear' => $cyear, 'provcode' => $provcode], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
                ],
                '{toggleData}',
                '{export}',
            ], 
        // set export properties
            'export' => [
		'showConfirmAlert'=>false,
                'fontAwesome' => false
            ],
            //'pjax' => true,
            'pjaxSettings' => [
                'neverTimeout' => true,
                'beforeGrid' => '',
                'afterGrid' => '',
            ],
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                ],
                [
                    'attribute' => 'hmain',
                    'format'=>'text', 
                    'header' => 'รหัส',
                    'hAlign' => 'center',
                ],
                [
                    'label' => 'ชื่อหน่วยบริการ',
                    'format' => 'raw',
                    'value' => function($model) use($provcode,$cyear){
                        return Html::a(Html::encode($model['hmainname']), ['/ppa2562/detailcvdrisk02', 'cyear' => $cyear, 'provcode' => $provcode, 'hospcode' => $model['hmain']]);
                    },
                    'pageSummary'=>'รวมทั้งหมด',
                    //'width' => '30%',          
                ], 
                [
                    'attribute'=>'sum61',
                    'header' => 'เป้าหมาย',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text danger'],  
                ],
                [
                    'attribute'=>'sco5_61',
                    'header' => 'S5',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],  
                ],
                [
                    'attribute'=>'sco4_61',
                    'header' => 'S4',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],  
                ],
                [
                    'attribute'=>'sco3_61',
                    'header' => 'S3',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],  
                ],
                [
                    'attribute'=>'sco2_61',
                    'header' => 'S2',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],  
                ],
                [
                    'attribute'=>'sco1_61',
                    'header' => 'S1',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],  
                ],
                [
                    'attribute'=>'sconull_61',
                    'header' => 'NoS',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],  
                ],
                                                  
                [
                    'attribute'=>'sum62',
                    'header' => 'เป้าหมาย',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],  
                    'contentOptions' => ['class'=>'text danger'],  
                ],
                [
                    'attribute'=>'sco5_62',
                    'header' => 'S5',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],  
                ],
                [
                    'attribute'=>'sco4_62',
                    'header' => 'S4',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],  
                ],
                [
                    'attribute'=>'sco3_62',
                    'header' => 'S3',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],  
                ],
                [
                    'attribute'=>'sco2_62',
                    'header' => 'S2',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],  
                ],
                [
                    'attribute'=>'sco1_62',
                    'header' => 'S1',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],  
                ],
                [
                    'attribute'=>'sconull_62',
                    'header' => 'NoS',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],  
                ],
            ]
        ]);
        ?>
     </div>
</div>
<div class="pull-right">
    <span class="glyphicon glyphicon-time"></span> วันที่ประมวลผล <?php echo $date; ?> น.
</div>
<div class="row">
    <div class="col-lg-12">
        <strong class="text-danger">คำอธิบาย</strong>
        <div class="pull-left">
            <font color="blue"> * ผลการประเมินโอกาสเสี่ยงต่อการเกิดโรคหัวใจและหลอดเลือด (CVD Risk) การเปลี่ยน SCORE ลดลงของกลุ่มเสี่ยงสูง (>=20%)และเสี่ยงสูงมาก (>=30%) หลังเข้ารับการ
            ปรับเปลี่ยนพฤติกรรมอย่างเข้มข้นและรีบด่วน ภายใน 1 เดือน และ 3 เดือน</font>
            <font color="red"> เกณฑ์เป้าหมาย ไม่น้อยกว่าร้อยละ 100 </font>
        </div>

        <div class="bs-callout bs-callout-warning" id="callout-btn-group-anchor-btn"> 
            <code>&lt;S1-S5&gt;</code>คือ ค่า score <br>
            <code>&lt;NoS&gt;</code>  คือ score ที่มีค่าว่าง
        </div>

 </div>
                
        

</div>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>