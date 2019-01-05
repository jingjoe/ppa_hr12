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
$this->title = 'รายงานผลการบันทึกโครงการ P&P Area Based';
$this->params['breadcrumbs'][] = ['label' => 'ผลการบันทึกโครงการ P&P Area Based', 'url' => ['/report2/index']];
?>

<div class="box-header with-border">
    <h3 class="box-title"><span class="glyphicon glyphicon-object-align-bottom"></span> <?= Html::encode($this->title) ?> </h3>
</div>

 <div class='bg-success'>
        <?php $form = ActiveForm::begin([
                    'layout' => 'inline',
                    'action' => ['rep01'],
                   // 'method' => 'get',
        ]);
        ?>
            <div class="form-group">
                <label class="control-label"> ปี : </label>
                    <?php
                        $list_y = [
                            '2562' => '2562',
                            '2561' => '2561'];
                        echo Html::dropDownList('cyear',$cyear,$list_y,['class' => 'form-control']);
                    ?>

                    <label class="control-label"> รหัสโครงการ : </label>
                        <input type="text" name="sepacode" id="sepacode" class="form-control" placeholder="ระบุรหัสโครงการ...">
            </div>
           
            <div class="form-group">
                    <button class="btn btn-info btn-flat" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
            </div>
                
         
    <?php ActiveForm::end(); ?>
</div>
<br>
<div class="panel panel-default">          
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
                   GridView::EXCEL=> ['label' => 'ส่งออกไฟล์ excel', 'filename' => 'year'. $cyear.'_'.'ppa_code'. $pacode.'_'.date('Y-d-m')],
                ],
        // set your toolbar
            'toolbar' =>  [
                ['content' => 
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['rep01','byear' => $cyear,'pacode'=>$pacode], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
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
                    'attribute' => 'BYEAR',
                    'header' => 'ปี',
                ],
		[
                    'attribute' => 'IDPROJECT',
                    'header' => 'รหัสโครงการ',
                    'contentOptions' => [
                        'style'=>'max-width:100px;'
                    ],
                ],
                [
                    'label' => 'ชื่อโครงการ',
                    'format' => 'raw',
                    'value' => function($model){
                        return Html::a(Html::encode($model['NAMEPROJECT']), ['/report2/detail1','byear' => $model['BYEAR'], 'pacode' => $model['IDPROJECT']]);
                    },
                    'contentOptions' => [
                        'style'=>'max-width:900px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                ],        
            ],
        ]);
        ?>
    </div>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-right">
            <span class="glyphicon glyphicon-time"></span> วันที่ประมวลผล <?php echo $date; ?> น.
        </div>
    </div>
</div>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>
