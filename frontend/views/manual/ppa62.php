
<?php
use yii\helpers\Url;
$this->title = Yii::t('app', 'การบริหารค่าใช้จ่ายบริการสร้างเสริมสุขภาพและป้องกันโรค ปี 2562');

?>
<br>
<?= \yii2assets\pdfjs\PdfJs::widget([
        'width'=>'100%',
        'height'=> '100vh',
        'url'=> Url::base().'/manual/e_ppa2562_r12.pdf'
]); ?>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>
