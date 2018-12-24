<?php
$this->title = Yii::t('app', 'คู่มือการใช้งาน');

use yii\helpers\Html;
?>
<div class="panel panel-success">
    <!-- Default panel contents -->
    <div class="panel-heading"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> คู่มือการใช้งาน</div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon-folder-open"></span> <?= Html::a('<i class="fa  fa-database text-yellow"></i> การบันทึกข้อมูลผลงานโครงการ PPA-2561 ของหน่วยบริการในโปรแกรม JHCIS และ HOSxP (Key ในช่อง Chiefcomp)', ['/manual/keyppahis']); ?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-folder-open"></span> <?= Html::a('<i class="fa  fa-database text-yellow"></i> แนวทางการดำเนินงานและการบันทึกข้อมูล โครงการคัดกรองมะเร็งลาไส้ใหญ่และไส้ตรง ด้วยวิธี FIT test', ['/manual/fittest']); ?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-folder-open"></span> <?= Html::a('<i class="fa  fa-database text-yellow"></i> การบันทึกโครงการคัดกรองตรวจคัดกรองมะเร็งลำไส้ใหญ่ด้วยวิธี FIT test 100 สำหรับโปรแกรม HOSxP และ JHCIS', ['/manual/keyfittest100']); ?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-folder-open"></span> <?= Html::a('<i class="fa  fa-database text-yellow"></i> แนวทางบริหารจัดการงบบริการสร้างเสริมสุขภาพและป้องกันโรคที่เป็นปัญหาพื้นที่ระดับเขต/จังหวัด สปสช.เขต 12 สงขลา ปีงบประมาณ 2562', ['/manual/eppa62']); ?> <?php echo Html::img('@web/images/new.png') ?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-folder-open"></span> <?= Html::a('<i class="fa  fa-database text-yellow"></i> ประชุมชี้แจงการบันทึกข้อมูลรายละเอียดโครงการแม่คุณภาพสู่ Smart kids 4.0 เขตสุขภาพที่ 12 ปีงบประมาณ 2561 วันที่ 28 พฤศจิกายน 2562 ณ ห้องประชุมนายแพทย์จำลองบ่อเกิด ชั้น 5 รพ.หาดใหญ่', ['/manual/tosmartkids']); ?> <?php echo Html::img('@web/images/new.png') ?></li>
        </ul>

    </div>
</div>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>

