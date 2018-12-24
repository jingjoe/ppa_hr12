
<?php
use yii\helpers\Url;
$this->title = Yii::t('app', 'แนวทางการดำเนินงานและการบันทึกข้อมูล โครงการคัดกรองมะเร็งลาไส้ใหญ่และไส้ตรง ด้วยวิธี FIT test');

?>
<br>
<?= \yii2assets\pdfjs\PdfJs::widget([
        'width'=>'100%',
        'height'=> '100vh',
        'url'=> Url::base().'/manual/fittest100.pdf'
]); ?>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>