
<?php
use yii\helpers\Url;
$this->title = Yii::t('app', 'การบันทึกข้อมูลผลงานโครงการ PPA-2561 ของหน่วยบริการในโปรแกรม JHCIS และ HOSxP');

?>
<br>
<?= \yii2assets\pdfjs\PdfJs::widget([
        'width'=>'100%',
        'height'=> '100vh',
        'url'=> Url::base().'/manual/key_his_ppa2561.pdf'
]); ?>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>
