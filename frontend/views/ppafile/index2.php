<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ดาวน์โหลดไฟล์';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programs-index2">
<!-- File Update -->
    <div class="panel panel-success">
        
        <div class="panel-heading"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> ดาวน์โหลดไฟล์</div>
        <div class="panel-body">
               <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'detail:ntext',
            'create_date',
            'hits',
            ['attribute' => 'download',
            'label' => 'Download',
            'format' => 'raw',
            'value' => function($data) {
                return
                        Html::a('Download', ['ppafile/download', 'type' => 'files', 'id' => $data->id], ['class' => 'label label-success']);
            }
            ],
     

           //['class' => 'yii\grid\ActionColumn'],
         
            ],
    ]); ?>
        </div>
    </div>


</div>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>