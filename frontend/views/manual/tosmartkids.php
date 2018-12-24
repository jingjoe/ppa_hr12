
<?php
use yii\helpers\Url;
$this->title = Yii::t('app', 'แม่คุณภาพสู่ Smart kids 4.0 เขตสุขภาพที่ 12 ปีงบประมาณ 2561');

?>
<br>
<?= \yii2assets\pdfjs\PdfJs::widget([
        'width'=>'100%',
        'height'=> '100vh',
        'url'=> Url::base().'/manual/to_smartkids4.0.pdf'
]); ?>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>
