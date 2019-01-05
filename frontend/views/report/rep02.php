<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use kartik\grid\GridView;

use miloschuman\highcharts\Highcharts;



$this->title = 'ผลการการบันทึกโครงการ P&P Area Based';
$this->params['breadcrumbs'][] = ['label' => 'Go Back', 'url' => ['report/rep01','cyear'=>$cyear,'provcode'=>$provcode,'pacode'=>$pacode]];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div style='display: none'>
    <?=
    Highcharts::widget([
        'scripts' => [
            'highcharts-more',
            'themes/grid',
            //'modules/exporting',
            'modules/solid-gauge',
        ]
    ]);
    ?>
</div>
<?php foreach ($ppaname as $ppa) { ?>
<?php } ?> 

<div class="panel panel-default">
    <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span>  โครงการ  <?php echo $ppa['ppaname']; ?> <span class="glyphicon glyphicon-tags"></span> โรงพยาบาลแม่ข่าย : <?php echo $hosmain; ?> ปี <?php echo $cyear; ?></h3> </div>
    <div class="panel-body">
        <div id="container-line"></div>
        <?php

        $categ = [];
        for ($i = 0; $i < count($chart); $i++) {
            $categ[] = $chart[$i]['hsubname'];
        }
        $js_categ = implode("','", $categ);

        $data_cc = [];
        for ($i = 0; $i < count($chart); $i++) {
            $data_cc[] = $chart[$i]['result'];
        }
        $js_cc = implode(",", $data_cc);

        $this->registerJs(" $(function () {
                            $('#container-line').highcharts({
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: '',
                                    x: -20 //center
                                },
                                subtitle: {
                                    text: '',
                                    x: -20
                                },
                                xAxis: {
                                      categories: ['$js_categ'],
                                },
                                yAxis: {
                                    title: {
                                        text: ''
                                    },
                                    plotLines: [{
                                        value: 100,
                                        width: 2,
                                        color: 'red',
                                        dashStyle: 'shortdash',
                                        label:{text:'' , align: 'right',x: +50}
                                    }]
                                },
   
                                tooltip: {
                                    valueSuffix: ''
                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle',
                                    borderWidth: 0
                                },
                                credits: {
                                    enabled: false
                                },
                                series: [{
                                    name: 'หน่วยบริการ',
                                    data: [$js_cc]
                                }]
                            });
                        });
             ");
        ?>
<br>
    <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'showPageSummary'=>true,
            'headerRowOptions' => ['style' => 'background-color:#cccccc'],
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                //'after' => 'วันที่ประมวลผล '.date('Y-m-d H:i:s').' น.',
                'footer'=>false
            ],
            'responsive' => true,
            'hover' => true,
			'autoXlFormat'=>true,
            'exportConfig' => [
                   GridView::EXCEL=> ['label' => 'ส่งออกไฟล์ excel', 'filename' => 'ppa_y'.$cyear.'hmain'.$hosmain.'ppa_code'.$pacode.'date'.date('Y-d-m')],
                ],
        // set your toolbar
           'toolbar' =>  [
                ['content' => 
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['rep02', 'cyear' => $cyear, 'provcode' => $provcode, 'hospcode' => $hosmain,'pacode' => $pacode], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
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
                    'class' => 'kartik\grid\SerialColumn'
                ],
                [
                    'attribute' => 'byear',
                    'header' => 'ปี'
                ],
                [
                    'attribute' => 'hospcode',
                    'format'=>'text', 
                    'header' => 'รหัสหน่วยบริการ'
                ],
                [
                    'attribute' => 'hsubname',
                    'header' => 'ชื่อหน่วยบริการ',
                    'pageSummary'=>'ผลงานรวม',
                    'width' => '70%',  
                ], 
                [
                    'attribute'=>'result',
                    'header' => 'ผลงาน',
                    'hAlign'=>'right',
                    'format'=>['decimal', 0],
                    'pageSummary'=>true
                ],
            ]
        ]);
        ?>
     </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-right">
            <span class="glyphicon glyphicon-time"></span> วันที่ประมวลผล <?php echo $date; ?> น.
        </div>
    </div>
</div>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>