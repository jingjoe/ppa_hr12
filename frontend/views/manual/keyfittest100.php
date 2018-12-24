
<?php
use yii\helpers\Url;
$this->title = Yii::t('app', 'การบันทึกโครงการคัดกรองตรวจคัดกรองมะเร็งลำไส้ใหญ่ด้วยวิธี FITTest 100 สำหรับโปรแกรม HOSxP และ JHCIS');

?>
<br>
<?= \yii2assets\pdfjs\PdfJs::widget([
        'width'=>'100%',
        'height'=> '100vh',
        'url'=> Url::base().'/manual/key_fittest100_PA0461.pdf'
]); ?>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>
