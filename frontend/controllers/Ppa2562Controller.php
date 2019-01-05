<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;



class Ppa2562Controller extends Controller {
    
    public function actionEpifully($cyear=NULL ,  $provcode=NULL) {
        
            $q_date = "SELECT MAX(d_com) AS d_com FROM ppa62_epi_s_results WHERE  byear=$cyear  AND provcode=$provcode";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];
        
            $sql = "SELECT epi.byear,c.hmain,c.hmainname,
                    SUM(epi.ta2016) AS ta61,SUM(epi.re2016) AS re61,ROUND((SUM(epi.re2016)*100/SUM(epi.ta2016)),2) AS percent61,
                    SUM(epi.ta2017) AS ta62,SUM(epi.re2017) AS re62,ROUND((SUM(epi.re2017)*100/SUM(epi.ta2017)),2) AS percent62
                    FROM ppa62_epi_s_results epi
                    LEFT JOIN ppa_cmastercup c ON epi.hospcode = c.hsub
                    WHERE epi.byear='$cyear'
                    AND epi.provcode='$provcode'
                    GROUP BY c.hmain";
                
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
          
        
        return $this->render('epifully', [
            'dataProvider' => $dataProvider,
            'chart' => $data,
            'cyear' => $cyear, 
            'date' =>  $date,
            'provcode' => $provcode]);
    }
    
    public function actionDetailepi($cyear=NULL , $provcode=NULL , $hospcode=NULL) {
            
            $q_date = "SELECT IF(MIN(d_com) IS NULL,'0000-00-00 00:00:00',MIN(d_com)) AS d_com FROM ppa62_epi_s_results WHERE  byear=$cyear  AND provcode=$provcode AND hospcode=$hospcode";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];
           
            $sql = "SELECT c.hsub,c.hsubname,
                    epi.ta2016 AS ta61,epi.re2016 AS re61,ROUND((SUM(epi.re2016)*100/SUM(epi.ta2016)),2) AS percent61,
                    epi.ta2017 AS ta62,epi.re2017 AS re62,ROUND((SUM(epi.re2017)*100/SUM(epi.ta2017)),2) AS percent62
                    FROM ppa_cmastercup c
                    INNER JOIN ppa62_epi_s_results epi ON epi.hospcode = c.hsub
                    WHERE epi.byear = '$cyear' 
                    AND epi.provcode = '$provcode'
                    AND c.hmain = '$hospcode'
                    GROUP BY c.hsub ";

        
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
    
        return $this->render('detailepi', [
            'dataProvider' => $dataProvider,
            'hosmain' => $hospcode,
            'chart' => $data,
            'date' =>  $date,
            'cyear' => $cyear, 
            'provcode' => $provcode]);
    }

    public function actionCvdrisk01($cyear=NULL ,  $provcode=NULL) {
        
            $q_date = "SELECT MAX(d_com) AS d_com FROM ppa62_cvd_s_results WHERE  byear=$cyear  AND provcode=$provcode";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];
        
            $sql = "SELECT cvd.byear,c.hmain,c.hmainname,SUM(cvd.COUNT2561) AS sum61,SUM(cvd.COUNT2562) AS sum62,ROUND((SUM(cvd.COUNT2562)*100/SUM(cvd.COUNT2561)),2) AS percent
                    FROM ppa62_cvd_s_results cvd
                    LEFT JOIN ppa_cmastercup c ON cvd.hospcode = c.hsub
                    WHERE cvd.byear='$cyear'
                    AND cvd.provcode='$provcode'
                    GROUP BY c.hmain";
                
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
          
        
        return $this->render('cvdrisk01', [
            'dataProvider' => $dataProvider,
            'chart' => $data,
            'cyear' => $cyear, 
            'date' =>  $date,
            'provcode' => $provcode]);
    }
        public function actionDetailcvdrisk01($cyear=NULL , $provcode=NULL , $hospcode=NULL) {
            
            $q_date = "SELECT IF(MIN(d_com) IS NULL,'0000-00-00 00:00:00',MIN(d_com)) AS d_com  FROM ppa62_cvd_s_results WHERE  byear=$cyear  AND provcode=$provcode AND hospcode=$hospcode ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];
           
            $sql = "SELECT c.hsub,c.hsubname,cvd.COUNT2561,cvd.COUNT2562,ROUND((cvd.COUNT2562*100/cvd.COUNT2561),2) AS percent
                    FROM ppa_cmastercup c
                    INNER JOIN ppa62_cvd_s_results cvd ON cvd.hospcode = c.hsub
                    WHERE cvd.byear = '$cyear' 
                    AND cvd.provcode = '$provcode'
                    AND c.hmain = '$hospcode'
                    GROUP BY c.hsub ";

        
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
    
        return $this->render('detailcvdrisk01', [
            'dataProvider' => $dataProvider,
            'hosmain' => $hospcode,
            'chart' => $data,
            'date' =>  $date,
            'cyear' => $cyear, 
            'provcode' => $provcode]);
    }
        public function actionCvdrisk02($cyear=NULL ,  $provcode=NULL) {
        
            $q_date = "SELECT MAX(d_com) AS d_com FROM ppa62_cvd_s_results WHERE  byear=$cyear  AND provcode=$provcode";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];
        
            $sql = "SELECT cvd.byear,c.hmain,c.hmainname,
                    SUM(cvd.COUNT2561) AS sum61,
                    SUM(cvd.SCORE5_2561) AS sco5_61,SUM(cvd.SCORE4_2561) AS sco4_61,SUM(cvd.SCORE3_2561) AS sco3_61,SUM(cvd.SCORE2_2561) AS sco2_61,SUM(cvd.SCORE1_2561) AS sco1_61,SUM(cvd.SCORE_NULL_2561) AS sconull_61,
                    SUM(cvd.COUNT2562) AS sum62,
                    SUM(cvd.SCORE5_2562) AS sco5_62,SUM(cvd.SCORE4_2562) AS sco4_62,SUM(cvd.SCORE3_2562) AS sco3_62,SUM(cvd.SCORE2_2562) AS sco2_62,SUM(cvd.SCORE1_2562) AS sco1_62,SUM(cvd.SCORE_NULL_2562) AS sconull_62
                    FROM ppa62_cvd_s_results cvd
                    LEFT JOIN ppa_cmastercup c ON cvd.hospcode = c.hsub
                    WHERE cvd.byear='$cyear'
                    AND cvd.provcode='$provcode'
                    GROUP BY c.hmain";
                
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
          
        
        return $this->render('cvdrisk02', [
            'dataProvider' => $dataProvider,
            'chart' => $data,
            'cyear' => $cyear, 
            'date' =>  $date,
            'provcode' => $provcode]);
    }
        public function actionDetailcvdrisk02($cyear=NULL , $provcode=NULL , $hospcode=NULL) {
            
            $q_date = "SELECT IF(MIN(d_com) IS NULL,'0000-00-00 00:00:00',MIN(d_com)) AS d_com  FROM ppa62_cvd_s_results WHERE  byear=$cyear  AND provcode=$provcode AND hospcode=$hospcode ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];
           
            $sql = "SELECT c.hsub,c.hsubname,cvd.COUNT2561,
                    cvd.SCORE5_2561,cvd.SCORE4_2561,cvd.SCORE3_2561,cvd.SCORE2_2561,cvd.SCORE1_2561,cvd.SCORE_NULL_2561,
                    cvd.COUNT2562,
                    cvd.SCORE5_2562,cvd.SCORE4_2562,cvd.SCORE3_2562,cvd.SCORE2_2562,cvd.SCORE1_2562,cvd.SCORE_NULL_2562,
                    cvd.TOTAL_2561,cvd.TOTAL_2562,total,CVD_SCORE_DOWN
                    FROM ppa_cmastercup c
                    INNER JOIN ppa62_cvd_s_results cvd ON cvd.hospcode = c.hsub
                    WHERE cvd.byear = '$cyear' 
                    AND cvd.provcode = '$provcode'
                    AND c.hmain = '$hospcode'
                    GROUP BY c.hsub ";

        
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
    
        return $this->render('detailcvdrisk02', [
            'dataProvider' => $dataProvider,
            'hosmain' => $hospcode,
            'chart' => $data,
            'date' =>  $date,
            'cyear' => $cyear, 
            'provcode' => $provcode]);
    }

}  
