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

<div class="panel panel-default">
    <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span>  โครงการ จัดบริการวัคซีนป้องกันโรคแต่ละชนิดครบตามเกณฑ์ในเด็กอายุครบ 1 ปี (Fully immunized) ปี <?php echo $cyear; ?></h3> </div>
    <div class="panel-body">
             <div id="container-line"></div>
        <?php

        $categ = [];
        for ($i = 0; $i < count($chart); $i++) {
            $categ[] = $chart[$i]['hmainname'];
        }
        $js_categ = implode("','", $categ);

        $data_cc1 = [];
        for ($i = 0; $i < count($chart); $i++) {
            $data_cc1[] = $chart[$i]['percent61'];
        }
        $js_cc1 = implode(",", $data_cc1);

        $data_cc2 = [];
        for ($i = 0; $i < count($chart); $i++) {
            $data_cc2[] = $chart[$i]['percent62'];
        }
        $js_cc2 = implode(",", $data_cc2);


        $this->registerJs(" $(function () {
            $('#container-line').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'จัดบริการวัคซีนป้องกันโรคแต่ละชนิดครบตามเกณฑ์ในเด็กอายุครบ 1 ปี (Fully immunized)'
                },
                subtitle: {

                },
                xAxis: {
                      categories: ['$js_categ'],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    title: {
                        text: 'ร้อยละ'
                    },
                    plotLines: [{
                        value: 90,
                        width: 2,
                        color: 'red',
                        dashStyle: 'shortdash',
                        label:{text:'' , align: 'right',x: +50}
                    }]
                },
                tooltip: {
                    valueSuffix: ''
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'ข้อมูลปี 2561 (ร้อยละ)',
                    data: [$js_cc1]
                }, {
                    name: 'ข้อมูลปี 2562 (ร้อยละ)',
                    data: [$js_cc2]
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
            'beforeHeader'=>[
                [
                    'columns'=>[
                        ['content'=>'', 'options'=>['colspan'=>3, 'class'=>'text-center default']], 
                        ['content'=>'ข้อมูลปี 2561', 'options'=>['colspan'=>3, 'class'=>'text-center info']], 
                        ['content'=>'ข้อมูลปี 2562', 'options'=>['colspan'=>4, 'class'=>'text-center success']], 
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
                   GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'ppa_y'.$cyear.'date'.date('Y-d-m')],
                   GridView::PDF => ['label' => 'Export as PDF', 'filename' => 'ppa_y'.$cyear.'date'.date('Y-d-m')],
                   GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'ppa_y'.$cyear.'date'.date('Y-d-m')],
                   GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'ppa_y'.$cyear.'date'.date('Y-d-m')],
                ],
        // set your toolbar
            'toolbar' =>  [
                ['content' => 
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['epifully', 'cyear' => $cyear, 'provcode' => $provcode], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
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
                    'contentOptions' => ['class'=>'text-center warning']  
                ],
                [
                    'attribute' => 'hmain',
                    'format'=>'text', 
                    'header' => 'รหัสหน่วยบริการ',
                    'width' => '15%',

                ],
                [
                    'label' => 'ชื่อหน่วยบริการ',
                    'format' => 'raw',
                    'value' => function($model) use($provcode,$cyear){
                        return Html::a(Html::encode($model['hmainname']), ['/ppa2562/detailepi', 'cyear' => $cyear, 'provcode' => $provcode, 'hospcode' => $model['hmain']]);
                    },
                    'pageSummary'=>'รวมทั้งหมด',
                    'width' => '30%',
            
                            
                ], 
                [
                    'attribute'=>'ta61',
                    'header' => 'เป้าหมาย',
                    'hAlign'=>'right',
                    'contentOptions' => ['class'=>'text info'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'re61',
                    'header' => 'ผลงาน',
                    'hAlign'=>'right',
                    'contentOptions' => ['class'=>'text info'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'percent61',
                    'header' => 'ร้อยละ %',
                    'hAlign'=>'right',
                    'format'=>['decimal', 2],
                    'contentOptions' => ['class'=>'text info'],
                    'pageSummary'=>''
                ],
                [
                    'attribute'=>'ta62',
                    'header' => 'เป้าหมาย',
                    'hAlign'=>'right',
                    'contentOptions' => ['class'=>'text success'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'re62',
                    'header' => 'ผลงาน',
                    'hAlign'=>'right',
                    'contentOptions' => ['class'=>'text success'],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'percent62',
                    'header' => 'ร้อยละ %',
                    'hAlign'=>'right',
                    'format'=>['decimal', 2],
                    'contentOptions' => ['class'=>'text success'],
                    'pageSummary'=>''
                ],
                [
                    'class' => 'kartik\grid\DataColumn',
                    'attribute'=>'',
                    'hAlign' => 'center',
                    'format' => 'raw',
                    'header' => 'แปลผล',
                    'value'=>function($model,$url){
                        if($model['percent62'] >= $model['percent61'])
                        {
                             return '<span style="color:green"><i class="glyphicon glyphicon-arrow-up"></i></span>';
                        }
                        else
                        {
                           return '<span style="color:red"><i class="glyphicon glyphicon-arrow-down"></i></span>';
                        }
                    }
                ],
            ]
        ]);
        ?>
     </div>
</div>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>