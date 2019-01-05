<?php
use yii\helpers\Html;

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */

$this->title = 'การบริหารงบค่าใช้จ่ายบริการสร้างเสริมสุขภาพและป้องกันโรคที่เป็นปัญหาพื้นที่ระดับเขตหรือจังหวัด (P&P Area Based) สปสช.เขต 12';
?>
<div class="site-index">
<!-- popup start --> 
<!-- เพิ่ม funtion นี้ใน controller  SITE ,public function actionPopup(){return $this->renderAjax('popup');} -->
<!--	
    <script src="http://code.jquery.com/jquery.js"></script>
		<?php
			Modal::begin([
			'header' => '<h3 style="text-align:center;">แจ้งการปรับปรุงและแนวทางการแก้ไขรหัสโครงการ PPA ประจำปี 2561 </h3>',
			'headerOptions' => ['id' => 'modalHeader'],
			'id' => 'cityModal',
			'size' => 'modal-lg',
			'clientOptions' => ['backdrop' => 'static','tabindex'=>'-1']
			]);
				echo "<div id='modalContent'></div>";
			Modal::end();
		?>
    <script type="text/javascript">
        $(window).load(function() {
            var url = '<?= Url::to(['site/popup']); ?>';
            $('#cityModal').modal('show');
            $('#modalContent').load(url);
        });
    </script>
-->
<!-- popup end -->
    <div class='bg-success'>
        <?php $form = ActiveForm::begin([
            'layout' => 'inline'
            ]); ?>
            <div class="form-group">
                <label class="control-label"> ปี : </label>
                <?php
                    $list_y = [
                        '2562' => '2562',
                        '2561' => '2561'];
                    echo Html::dropDownList('cyear',$cyear,$list_y,['class' => 'form-control']);
                ?>
                <label class="control-label"> จังหวัด : </label>
                <?php
                    $list_p = [
                        '01' => 'เขต-สสจ',
                        '90' => 'สงขลา',
                        '91' => 'สตูล',
                        '92' => 'ตรัง',
                        '93' => 'พัทลุง',
                        '94' => 'ปัตตานี',
                        '95' => 'ยะลา',
                        '96' => 'นราธิวาส'];
                    echo Html::dropDownList('provcode',$provcode,$list_p,['class' => 'form-control']);
                ?>
            </div>

        
            <div class="form-group">
                <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> ค้นหา', ['class' => 'btn btn-info btn-flat']) ?>
            </div><!-- /.input group -->
       <?php ActiveForm::end(); ?>
    </div>

<br>
<?php
   if ($cyear == "2561") { 
      echo  GridView::widget([
            'dataProvider' => $dataProvider,
            'headerRowOptions' => ['style' => 'background-color:#cccccc'],
            'responsive' => true,
            'hover' => true,
            'pjax' => true,
            'pjaxSettings' => [
                'neverTimeout' => true,
                'beforeGrid' => '',
                'afterGrid' => '',
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'IDPROJECT',
                    'header' => 'รหัสโครงการ',
                    'width' => '10%',  
                ],
                [
                    'label' => 'ชื่อโครงการ',
                    'format' => 'raw',
                    'contentOptions' => [
                        'style'=>'max-width:1000px; overflow: auto; white-space: normal; word-wrap: break-word;'
                    ],
                    'value' => function($model) use($provcode,$cyear){
                        return Html::a(Html::encode($model['NAMEPROJECT']), ['/report/rep01','cyear' => $cyear, 'provcode' => $provcode,'pacode' => $model['IDPROJECT']]);
                    }  
                ],        
            ],
        ]);
   
    } 
?>

</div>


<?php
    if ($cyear == "2562" && $provcode<>'01') { 
        echo  $this->render('_ppa2562',[
            'cyear' => $cyear,
            'provcode' => $provcode
        ]);
    }  
?>

<div class="row">
    <div class="col-lg-12">
        <div class="pull-right">
            <span class="glyphicon glyphicon-time"></span> วันที่ประมวลผล <?php echo $date; ?> น.
        </div>
    </div>
</div>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>