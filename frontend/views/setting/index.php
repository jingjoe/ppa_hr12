<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'ตั้งค่าระบบ';

$this->registerCss(".btn-xlarge {
        padding: 18px 28px;
        font-size: 20px; //change this to your desired size
        line-height: normal;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }");
?>
<div class="site-index">
     <center> 
        <div id="res" style="display: none">
            <img src="images/process.gif">
        </div>
    </center>
    <br>
    <div class="row">
        <div class="col-sm-4">
            <?php
            $route = \Yii::$app->urlManager->createUrl('user/index');
            ?>
            <a class="btn btn-danger btn-block btn-xlarge" id="btn_2" href="<?= $route ?>"> 
                <i class="glyphicon glyphicon-lock"></i>  จัดการผู้ใช้งาน 
            </a>

        </div>
        <div class="col-sm-4">
            <?php
            $route = \Yii::$app->urlManager->createUrl('syssettime/index');
            ?>
            <a class="btn btn-success btn-block btn-xlarge" id="btn_1" href="<?= $route ?>"> 
                <i class="glyphicon glyphicon-time"></i>  ตั้งเวลาประมวลผล
            </a>

        </div>

        <div class="col-sm-4">
            <button class="btn bg-primary btn-block btn-xlarge" id="btn_rpt"> 
                <i class="glyphicon glyphicon-repeat"></i> ประมวลผล
            </button>
        </div>
    </div>
</div>
<?php

$route_exec = Yii::$app->urlManager->createUrl('execute/exec');


$script1 = <<< JS
        
 $('#btn_rpt').on('click', function () {
          $('#res').toggle();   
    $.ajax({
       url: "$route_exec",       
       success: function(data) {
           $('#res').toggle();               
            alert(data+' ประมวลผลสำเร็จ'); 
       }
    });
 });
               
JS;

$this->registerJs($script1);
?>
