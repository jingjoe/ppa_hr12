<?php
use yii\helpers\Html;

$this->title = Yii::t('app', 'รายงานผลการบันทึกโครงการ (P&P Area Based) สปสช.เขต 12');

?>

<div class="panel panel-success">
    <!-- Default panel contents -->
    <div class="panel-heading"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> รายงานผลการบันทึกโครงการ P&P Area Based</div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon-object-align-left"></span> <?= Html::a('<i class="fa  fa-database text-yellow"></i> ผลให้บริการสร้างเสริมสุขภาพและป้องกันโรค(P&P Area Based) แยกตามโครงการ', ['/report2/rep01']); ?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-object-align-left"></span> <?= Html::a('<i class="fa  fa-database text-yellow"></i> ผลให้บริการสร้างเสริมสุขภาพและป้องกันโรค(P&P Area Based) แยกตามหน่วยบริการ', ['/report2/rep02']); ?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-object-align-left"></span> <?= Html::a('<i class="fa  fa-database text-yellow"></i> ผลให้บริการสร้างเสริมสุขภาพและป้องกันโรค(P&P Area Based) ทั้งหมด <font color="red">*ต้อง Login เข้าสู่ระบบก่อน </font>', ['/report2/rep03']); ?></li>
        </ul>

    </div>
</div>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>


