<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use kartik\grid\GridView;

use miloschuman\highcharts\Highcharts;



$this->title = 'ผลการการบันทึกโครงการ P&P Area Based';
$this->params['breadcrumbs'][] = ['label' => 'Go Back', 'url' => ['ppa2562/cvdrisk02','cyear'=>$cyear,'provcode'=>$provcode]];
//$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-default">
    <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span>  ผลการประเมินโอกาสเสี่ยงต่อการเกิดโรคหัวใจและหลอดเลือด (CVD Risk) การเปลี่ยน SCORE ลดลง ปี <?php echo $cyear; ?></h3> </div>
    <div class="panel-body">
    <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'showPageSummary'=>true,
            'headerRowOptions' => ['style' => 'background-color:#cccccc'],
            'beforeHeader'=>[
                [
                    'columns'=>[
                        ['content'=>'', 'options'=>['colspan'=>3, 'class'=>'text-center default']], 
                        ['content'=>'ผลการประเมินโอกาสเสี่ยงปี 2561', 'options'=>['colspan'=>7, 'class'=>'text-center success']], 
                        ['content'=>'ผลการประเมินโอกาสเสี่ยงปี 2562', 'options'=>['colspan'=>7, 'class'=>'text-center info']], 
                        ['content'=>'การคัดกรองในแต่ละปี', 'options'=>['colspan'=>3, 'class'=>'text-center warning']],
                        ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center danger']],
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
                   GridView::EXCEL=> ['label' => 'ส่งออกไฟล์ excel', 'filename' => 'cvdrisk02_detail'.date('Y-d-m')],
                ],
        // set your toolbar
            'toolbar' =>  [
                ['content' => 
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['detailcvdrisk02', 'cyear' => $cyear, 'provcode' => $provcode,'hospcode' => $hosmain], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
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
                    'attribute' => 'hsub',
                    'format'=>'text', 
                    'header' => 'รหัส',
                    'hAlign' => 'center',

                ],
                [
                    'attribute' => 'hsubname',
                    'header' => 'ชื่อหน่วยบริการ',
                    'format' => 'raw',
                    'contentOptions' => [
                        'style'=>'max-width:1000px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                    'pageSummary'=>'ผลงานรวม',
                    //'width' => '10%',  
                ],
                [
                    'attribute'=>'COUNT2561',
                    'header' => 'เป้าหมาย',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],  
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE5_2561',
                    'header' => 'S5',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE4_2561',
                    'header' => 'S4',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE3_2561',
                    'header' => 'S3',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE2_2561',
                    'header' => 'S2',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE1_2561',
                    'header' => 'S1',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE_NULL_2561',
                    'header' => 'NoS',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],
                    'pageSummary'=>true
                ],
                                                  
                [
                    'attribute'=>'COUNT2562',
                    'header' => 'เป้าหมาย',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],  
                    'contentOptions' => ['class'=>'text info'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE5_2562',
                    'header' => 'S5',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE4_2562',
                    'header' => 'S4',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE3_2562',
                    'header' => 'S3',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'], 
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE2_2562',
                    'header' => 'S2',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'], 
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE1_2562',
                    'header' => 'S1',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'SCORE_NULL_2562',
                    'header' => 'NoS',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text info'],
                    'pageSummary'=>true
                ],
                                [
                    'attribute'=>'TOTAL_2561',
                    'header' => '%61',
                    'hAlign' => 'center',
                    'format'=>['decimal', 2],
                    'contentOptions' => ['class'=>'text warning'],
                    'pageSummary'=>'-'
                ],
                [
                    'attribute'=>'TOTAL_2562',
                    'header' => '%62',
                    'hAlign' => 'center',
                    'format'=>['decimal', 2],
                    'contentOptions' => ['class'=>'text warning'],
                    'pageSummary'=>'-'
                ],
                [
                    'attribute'=>'total',
                    'header' => '+/-',
                    'hAlign' => 'center',
                    'format'=>['decimal', 2],
                    'contentOptions' => ['class'=>'text warning'],
                    'pageSummary'=>'-'
                ],
                [
                    'attribute'=>'CVD_SCORE_DOWN',
                    'header' => 'sN+/-',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text danger'],
                    'pageSummary'=>'-'
                ],
//                [
//                    'class' => 'kartik\grid\DataColumn',
//                    'attribute'=>'',
//                    'hAlign' => 'center',
//                    'format' => 'raw',
//                    'header' => 'แปลผล',
//                    'value'=>function($model,$url){
//                        if($model['percent'] >= '85') 
//                        {
//                             return '<span style="color:green"><i class="glyphicon glyphicon-ok"></i></span>';
//                        }
//                        else
//                        {
//                           return '<span style="color:red"><i class="glyphicon glyphicon-remove"></i></span>';
//                        }
//                    },
//                    'pageSummary'=>'-'
//                ],
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
            <font color="blue"> * ผลการประเมินโอกาสเสี่ยงต่อการเกิดโรคหัวใจและหลอดเลือด (CVD Risk) การเปลี่ยน score ลดลงของกลุ่มเสี่ยงสูง (>=20%)และเสี่ยงสูงมาก (>=30%) หลังเข้ารับการ
            ปรับเปลี่ยนพฤติกรรมอย่างเข้มข้นและรีบด่วน ภายใน 1 เดือน และ 3 เดือน</font>
            <font color="red"> เกณฑ์เป้าหมาย ไม่น้อยกว่าร้อยละ 100 </font>
        </div>
        <div class="bs-callout bs-callout-warning" id="callout-btn-group-anchor-btn"> 
            <code>&lt;S1-S5&gt;</code>คือ ค่า score <br>
            <code>&lt;NoS&gt;</code>  คือ score ที่มีค่าว่าง  <br>
            <code>&lt;+/-&gt;</code>  คือ หาส่วนต่างของการคัดกรอง ระหว่าง ปี 2561 กับ ปี 2562 <br>
            <code>&lt;sN+/-&gt;</code> คือ หลังจากปรับเปลี่ยนแล้ว score ลดลง กี่คน
        </div>
    </div> 
</div>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>