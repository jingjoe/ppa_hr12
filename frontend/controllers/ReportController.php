<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;



class ReportController extends Controller {
    
    public function actionRep01($cyear=NULL ,  $provcode=NULL , $pacode=NULL) {
        

            $q_date = "SELECT MIN(d_com) AS d_com FROM ppa_s_pparesult WHERE byear=$cyear AND provcode=$provcode AND pacode='$pacode' ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];

            $sql_ppaname = "SELECT CONCAT(IDPROJECT,' : ',NAMEPROJECT)  AS ppaname FROM ppa_s_result WHERE IDPROJECT= '$pacode' ";

            $sql = "SELECT BYEAR,HOSPCODE,HOSPNAME,TARGET,RESULT,PERCENT
                    FROM ppa_s_result 
                    WHERE  BYEAR=$cyear 
                    AND PROVCODE=  '$provcode'
                    AND IDPROJECT=  '$pacode' ";
            
            
            $ppaname = Yii::$app->db->createCommand($sql_ppaname)->queryAll();
      
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);

        return $this->render('rep01', [
            'dataProvider' => $dataProvider,
            'ppaname' => $ppaname,
            'chart' => $data,
            'pacode' => $pacode,
            'date' =>  $date,
            'cyear' => $cyear, 
            'provcode' => $provcode]);
    }
    
    public function actionRep02($cyear=NULL , $provcode=NULL , $hospcode=NULL , $pacode=NULL) {
           
            $q_date = "SELECT MIN(d_com) AS d_com FROM ppa_s_pparesult WHERE byear=$cyear AND provcode=$provcode AND pacode='$pacode' ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];
            
            
            $sql_ppaname = "SELECT CONCAT(IDPROJECT,' : ',NAMEPROJECT)  AS ppaname FROM ppa_s_result WHERE IDPROJECT= '$pacode' ";
            
            $sql = "SELECT s.byear,s.hospcode,c.hsubname,s.result
                    FROM ppa_cmastercup c
                    INNER JOIN ppa_s_pparesult s ON s.hospcode = c.hsub
                    WHERE s.byear = '$cyear' 
                    AND s.provcode = '$provcode'
                    AND c.hmain = '$hospcode'
                    AND s.pacode = '$pacode' 
                    ORDER BY s.result  DESC ";
            
            $ppaname = Yii::$app->db->createCommand($sql_ppaname)->queryAll();
        
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
    
        return $this->render('rep02', [
            'dataProvider' => $dataProvider,
            'ppaname' => $ppaname,
            'hosmain' => $hospcode,
            'chart' => $data,
            'pacode' => $pacode,
            'date' =>  $date,
            'cyear' => $cyear, 
            'provcode' => $provcode]);
    }
}  
