<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;



class Ppa2562Controller extends Controller {
    
    public function actionEpifully($cyear=NULL ,  $provcode=NULL) {
        
            $sql = "SELECT c.hmain,c.hmainname,
                    SUM(pa.ta2016) AS ta61,SUM(pa.re2016) AS re61,ROUND((SUM(pa.re2016)*100/SUM(pa.ta2016)),2) AS percent61,
                    SUM(pa.ta2017) AS ta62,SUM(pa.re2017) AS re62,ROUND((SUM(pa.re2017)*100/SUM(pa.ta2017)),2) AS percent62
                    FROM cmastercup c
                    INNER JOIN ppa62_epi_s_results pa ON pa.hospcode=c.hmain
                    WHERE LEFT(c.province_id,2)='$provcode'
                    GROUP BY pa.hospcode";
                
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
          
        
        return $this->render('epifully', [
            'dataProvider' => $dataProvider,
            'chart' => $data,
            'cyear' => $cyear, 
            'provcode' => $provcode]);
    }
    
    
    public function actionCvdrisk01($cyear=NULL ,  $provcode=NULL) {
        
        return $this->render('cvdrisk01', [
            'cyear' => $cyear, 
            'provcode' => $provcode]);
    }
    
    public function actionCvdrisk02($cyear=NULL ,  $provcode=NULL) {
        
        return $this->render('cvdrisk02', [
            'cyear' => $cyear, 
            'provcode' => $provcode]);
    }
    
}  
