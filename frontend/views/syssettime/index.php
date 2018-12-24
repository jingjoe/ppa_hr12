<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ตั้งเวลาประมวลผล';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่าระบบ', 'url' => ['/setting/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-set-time-index">
 
            <h4> <?= Html::a('<span class="glyphicon glyphicon-time" aria-hidden="true"></span> ตั้งเวลาประมวลผล', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
            
            </h4>

  <div class="box">

        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            'time',
            'days',
            ['class' => 'yii\grid\ActionColumn', 
                'template' => '{view}<span class="glyphicon glyphicon-option-vertical"></span>{update}<span class="glyphicon glyphicon-option-vertical"></span>{delete}'
            ],
        ],
    ]); ?>

</div>
        </div>
    </div>
 
   <?= \bluezed\scrollTop\ScrollTop::widget() ?>