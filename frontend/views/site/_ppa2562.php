<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-success"> 
                <div class="panel-heading">
                    <h3 class="panel-title text-center" >กิจกรรมที่ 1 </h3>
                    <p> ตัวชี้วัดที่ 1 จัดบริการวัคซีนป้องกันโรคแต่ละชนิดครบตามเกณฑ์ในเด็กอายุครบ 1 ปี (Fully immunized)</p> <br>
                </div> 
                
                <div class="panel-body"> 
                      <?php echo Html::a(Html::img(Yii::getAlias('@web') . '/images/vaccine.png', ['alt' => 'some', 'class' => 'img-responsive']), ['ppa2562/epifully','cyear' => $cyear, 'provcode' => $provcode]); ?>

                </div> 
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-info"> 
                <div class="panel-heading">
                    <h3 class="panel-title text-center" >กิจกรรมที่ 2 </h3>
                    <p> ตัวชี้วัดที่ 1 ร้อยละของกลุ่มเสี่ยงได้รับการประเมินโอกาสเสี่ยงต่อโรคหัวใจและหลอดเลือด (CVD Risk)</p> <br>
                </div> 
                <div class="panel-body"> 
                      <?php echo Html::a(Html::img(Yii::getAlias('@web') . '/images/cvd_risk1.png', ['alt' => 'some', 'class' => 'img-responsive']), ['ppa2562/cvdrisk01','cyear' => $cyear, 'provcode' => $provcode]); ?>

                  
                </div> 
            </div>
        </div>
        
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-warning"> 
                <div class="panel-heading">
                    <h3 class="panel-title text-center" >กิจกรรมที่ 2 </h3>
                    <p> ตัวชี้วัดที่ 2 ผลการประเมินโอกาสเสี่ยงต่อการเกิดโรคหัวใจและหลอดเลือด (CVD Risk) การเปลี่ยน SCORE ลดลง </p>
                </div> 
                <div class="panel-body"> 
                      <?php echo Html::a(Html::img(Yii::getAlias('@web') . '/images/cvd_risk2.png', ['alt' => 'some', 'class' => 'img-responsive']), ['ppa2562/cvdrisk02','cyear' => $cyear, 'provcode' => $provcode]); ?>

                  
                </div> 
            </div>
        </div>
    </div>   