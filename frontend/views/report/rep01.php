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
<?php foreach ($ppaname as $ppa) { ?>
<?php } ?> 

<div class="panel panel-default">
    <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span>  โครงการ  <?php echo $ppa['ppaname']; ?> ปี <?php echo $cyear; ?></h3> </div>
    <div class="panel-body">
        <div id="container-line"></div>
        <?php

        $categ = [];
        for ($i = 0; $i < count($chart); $i++) {
            $categ[] = $chart[$i]['HOSPNAME'];
        }
        $js_categ = implode("','", $categ);

        $data_cc = [];
        for ($i = 0; $i < count($chart); $i++) {
            $data_cc[] = $chart[$i]['PERCENT'];
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
 <?php
    
    $data = $dataProvider->getModels();
    
    //target
        $categ = [];
        for ($i = 0; $i < count($data); $i++) {
            $categ[] = $data[$i]['TARGET'];
        }
        $t = implode(",", $categ);
        
  
        $target = 0;
        foreach(explode(',',$t) as $val)
             $target +=intval($val);

        //echo $target;

    // result  
        $categ = [];
        for ($i = 0; $i < count($data); $i++) {
            $categ[] = $data[$i]['RESULT'];
        }
        $r = implode(",", $categ);
        
  
        $result = 0;
        foreach(explode(',',$r) as $val)
             $result +=intval($val);

        //echo $result;
        
        $percent = number_format($result*100/$target, 2, '.', '');
 ?>

    <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'rowOptions' => function ($model) {
                if ($model['PERCENT'] <= 70) {
                    return ['class' => 'danger'];
                }
                    return ['class' => 'success'];
            }, 
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
                   GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'ppa_y'.$cyear.'ppa_code'.$pacode.'date'.date('Y-d-m')],
                   GridView::PDF => ['label' => 'Export as PDF', 'filename' => 'ppa_y'.$cyear.'ppa_code'.$pacode.'date'.date('Y-d-m')],
                   GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'ppa_y'.$cyear.'ppa_code'.$pacode.'date'.date('Y-d-m')],
                   GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'ppa_y'.$cyear.'ppa_code'.$pacode.'date'.date('Y-d-m')],
                ],
        // set your toolbar
            'toolbar' =>  [
                ['content' => 
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['rep01', 'cyear' => $cyear, 'provcode' => $provcode,'pacode' => $pacode], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
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
                    'attribute' => 'BYEAR',
                    'header' => 'PPA ปี'
                ],
                [
                    'attribute' => 'HOSPCODE',
                    'format'=>'text', 
                    'header' => 'รหัสหน่วยบริการ'
                ],
                [
                    'label' => 'ชื่อหน่วยบริการ',
                    'format' => 'raw',
                    'value' => function($model) use($provcode,$pacode,$cyear){
                        return Html::a(Html::encode($model['HOSPNAME']), ['/report/rep02', 'cyear' => $cyear, 'provcode' => $provcode, 'hospcode' => $model['HOSPCODE'],'pacode' => $pacode]);
                    },
                    'pageSummary'=>'รวมทั้งหมด',
                    'width' => '50%',
                            
                ], 
                [
                    'attribute'=>'TARGET',
                    'header' => 'เป้าหมาย',
                    'hAlign'=>'right',
                    'format'=>['decimal', 0],
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'RESULT',
                    'header' => 'ผลงาน',
                    'hAlign'=>'right',
                    'format'=>['decimal', 0],
                    'pageSummary'=>true
                ],
                [
                    'attribute' => 'PERCENT', 
                    'label' => 'ร้อยละ %',
                    'vAlign' => 'middle',
                    'hAlign'=>'right',
                    'format'=>['decimal', 2],
                    'width' => '10%',
                    'pageSummary' => $percent
                ], 
               /* [
                    'class' => 'kartik\grid\FormulaColumn', 
                    'header' => 'ร้อยละ %', 
                    'vAlign' => 'middle',
                    'hAlign'=>'right',
                    'width' => '10%',
                    'value' => function ($model, $key, $index, $widget) { 
                        $p = compact('model', 'key', 'index');
                        return $widget->col(4, $p) != 0 ? $widget->col(5, $p) * 100 / $widget->col(4, $p) : 0;
                    },
                    'format' => ['decimal', 2],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'mergeHeader' => true,
                    'pageSummary' => true,
                    'pageSummaryFunc' => GridView::F_AVG,
                    'footer' => true
                ],*/
            ]
        ]);
        ?>
     </div>
</div>
<span class="glyphicon glyphicon-time"></span> วันที่ประมวลผล <?php echo $date; ?> น.
<?= \bluezed\scrollTop\ScrollTop::widget() ?>