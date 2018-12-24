<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<span class="glyphicon glyphicon-equalizer"></span>  P&P Area Based',
        //'brandLabel' => 'KPI-HOSPITAL',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            //'class' => 'navbar-inverse navbar-fixed-top',
            'class' => 'navbar-fixed-top navbar-custom',
        ],
    ]);
    
    
    if (Yii::$app->user->isGuest) {
    $submenuItems[] = ['label' => '<span class="glyphicon glyphicon-log-in"></span>  เข้าสู่ระบบ', 'url' => ['/site/login']];
    $submenuItems[] = ['label' => '<span class="glyphicon glyphicon-user"></span>  สมาชิก', 'url' => ['/site/signup']];
} else {
    $submenuItems[] = ['label' => '<span class="glyphicon glyphicon-open"></span> อัพโหลดไฟล์', 'url' => ['/ppafile/index'],'visible' => Yii::$app->user->identity->role != 3];
    $submenuItems[] = ['label' => '<span class="glyphicon glyphicon-cog"></span> ตั้งค่าระบบ', 'url' => ['/setting/index'],'visible' => Yii::$app->user->identity->role == 1];
    $submenuItems[] = ['label' => '<span class="glyphicon glyphicon-log-out"></span>  ออกจากระบบ', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
}
$username = '';
if (!Yii::$app->user->isGuest) {
    $username = '(' . Html::encode(Yii::$app->user->identity->username) . ')';
}
$menuItems = [
    ['label' => '<span class="glyphicon glyphicon-home"></span> หน้าหลัก','url' => ['/site/index']],
    ['label' => '<span class="glyphicon glyphicon-stats"></span> รายงาน', 'url' => ['/report2/index']],
    ['label' => '<span class="glyphicon glyphicon-download-alt"></span> ดาวน์โหลดไฟล์', 'url' => ['ppafile/index2'],'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 1],
    ['label' => '<span class="glyphicon glyphicon-book"></span> คู่มือ', 'url' => ['/manual/index']],
	['label' => '<span class="glyphicon glyphicon-earphone"></span> ติดต่อ', 'url' => ['/site/about']],
    ['label' => '<span class="glyphicon glyphicon-lock"></span> ผู้ใช้งาน' . " " . $username,
        'items' => $submenuItems
    ],
];

echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
     'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
                <?php $cc = Yii::$app->db->createCommand("SELECT COUNT(id) FROM session_frontend_user")->queryScalar(); ?>
      <div class="container">
            <?php
                $ver = file_get_contents(Yii::getAlias('@webroot/version/version.txt'));
                $ver = explode(',', $ver);
            ?>    
          <p class="pull-left">P&P Area Based &copy;  <?= date('Y') ?> <a href="http://mis.rh12.moph.go.th/rh12/team.html" target="_blank">ทีมพัฒนาระบบสารสนเทศ เขตสุขภาพที่ 12</a> <b>Version : <?= $ver[0] ?> </b></p>
          <p class="pull-right">ผู้เยี่ยมชม <?= $cc;?> ครั้ง </p>
      </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
