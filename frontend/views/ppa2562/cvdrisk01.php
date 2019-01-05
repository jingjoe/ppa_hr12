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
    <div class="panel-heading"> <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span>  ร้อยละของกลุ่มเสี่ยงได้รับการประเมินโอกาสเสี่ยงต่อโรคหัวใจและหลอดเลือด (CVD Risk) ปี <?php echo $cyear; ?></h3> </div>
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
            $data_cc1[] = $chart[$i]['percent'];
        }
        $js_cc1 = implode(",", $data_cc1);

        $this->registerJs(" $(function () {
            $('#container-line').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'ร้อยละของกลุ่มเสี่ยงได้รับการประเมินโอกาสเสี่ยงต่อโรคหัวใจและหลอดเลือด (CVD Risk)'
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
                        value: 85,
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
                    name: 'กลุ่มเสี่ยงได้รับการประเมิน (ร้อยละ)',
                    data: [$js_cc1]
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
            $categ[] = $data[$i]['sum61'];
        }
        $t = implode(",", $categ);
        
  
        $target = 0;
        foreach(explode(',',$t) as $val)
             $target +=intval($val);

        //echo $target;

    // result  
        $categ = [];
        for ($i = 0; $i < count($data); $i++) {
            $categ[] = $data[$i]['sum62'];
        }
        $r = implode(",", $categ);
        
  
        $result = 0;
        foreach(explode(',',$r) as $val)
             $result +=intval($val);

        //echo $result;
        
        $percent = @number_format($result*100/$target, 2, '.', '');
 ?>
    <?=GridView::widget([
            'dataProvider' => $dataProvider,
//            'rowOptions' => function ($model) {
//                if ($model['percent'] < 85) {
//                    return ['class' => 'danger'];
//                }
//                    return ['class' => 'success'];
//            }, 
            'showPageSummary'=>true,
            'headerRowOptions' => ['style' => 'background-color:#cccccc'],
            'beforeHeader'=>[
                [
                    'columns'=>[
                        ['content'=>'', 'options'=>['colspan'=>3, 'class'=>'text-center default']], 
                        ['content'=>'กลุ่มเป้าหมายที่มีความเสี่ยง', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                        ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center default']], 
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
                   GridView::EXCEL=> ['label' => 'ส่งออกไฟล์ excel', 'filename' => 'cvdrisk01'.date('Y-d-m')],
            ],
        // set your toolbar
            'toolbar' =>  [
                ['content' => 
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['cvdrisk01', 'cyear' => $cyear, 'provcode' => $provcode], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
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
                    'hAlign' => 'center'
                ],
                [
                    'label' => 'ชื่อหน่วยบริการ',
                    'format' => 'raw',
                    'value' => function($model) use($provcode,$cyear){
                        return Html::a(Html::encode($model['hmainname']), ['/ppa2562/detailcvdrisk01', 'cyear' => $cyear, 'provcode' => $provcode, 'hospcode' => $model['hmain']]);
                    },
                    'pageSummary'=>'รวมทั้งหมด',
                    'width' => '50%',          
                ], 
                [
                    'attribute'=>'sum61',
                    'header' => 'ปี 2561',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],
                    'contentOptions' => ['class'=>'text success'],  
                    'pageSummary'=>true
                ],
                [
                    'attribute'=>'sum62',
                    'header' => 'ปี 2562',
                    'hAlign' => 'center',
                    'format'=>['decimal', 0],  
                    'contentOptions' => ['class'=>'text info'],  
                    'pageSummary'=>true
                ],
                [
                    'attribute' => 'percent', 
                    'label' => 'ร้อยละ %',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                    'format'=>['decimal', 2],
                    'contentOptions' => ['class'=>'text danger'],  
                    'width' => '10%',
                    'pageSummary' => $percent
                ],
                [
                    'class' => 'kartik\grid\DataColumn',
                    'attribute'=>'',
                    'hAlign' => 'center',
                    'format' => 'raw',
                    'header' => 'แปลผล',
                    'value'=>function($model,$url){
                        if($model['percent'] >= '85') 
                        {
                             return '<span style="color:green"><i class="glyphicon glyphicon-ok"></i></span>';
                        }
                        else
                        {
                           return '<span style="color:red"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                    },
                    'pageSummary'=>'-'
                ],
            ]
        ]);
        ?>
     </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-left">
            ร้อยละ = [กลุ่มเป้าหมายที่มีความเสี่ยง 2562*100/กลุ่มเป้าหมายที่มีความเสี่ยง 2561],
            แปลผล = [มากกว่าหรือเท่ากับ 85% <span style="color:green"><i class="glyphicon glyphicon-ok"></i></span> ,
            น้อยกว่า 85% <span style="color:red"><i class="glyphicon glyphicon-remove"></i></span> ] 
        </div>
        <div class="pull-right">
            <span class="glyphicon glyphicon-time"></span> วันที่ประมวลผล <?php echo $date; ?> น.
        </div>
    </div>
</div>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>