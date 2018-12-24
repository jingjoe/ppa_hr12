<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;



class ReportController extends Controller {
    
    public function actionRep01($cyear=NULL ,  $provcode=NULL , $pacode=NULL) {
        
        if ($cyear == "2562") {
            
            $q_date = "SELECT MIN(d_com) AS d_com FROM s_pparesult WHERE byear=$cyear AND provcode=$provcode AND pacode='$pacode' ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];

            $sql_ppaname = "SELECT CONCAT(IDPROJECT,' : ',NAMEPROJECT)  AS ppaname FROM s_result_2562 WHERE IDPROJECT= '$pacode' ";

            $sql = "SELECT BYEAR,HOSPCODE,HOSPNAME,TARGET,RESULT,PERCENT
                FROM s_result_2562
                WHERE  BYEAR=$cyear 
                AND PROVCODE=  '$provcode'
		        AND IDPROJECT=  '$pacode' ";
            
            $ppaname = Yii::$app->db->createCommand($sql_ppaname)->queryAll();
       

            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
        } else {
            $q_date = "SELECT MIN(d_com) AS d_com FROM s_pparesult WHERE byear=$cyear AND provcode=$provcode AND pacode='$pacode' ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];

            $sql_ppaname = "SELECT CONCAT(IDPROJECT,' : ',NAMEPROJECT)  AS ppaname FROM s_result WHERE IDPROJECT= '$pacode' ";

            $sql = "SELECT BYEAR,HOSPCODE,HOSPNAME,TARGET,RESULT,PERCENT
                FROM s_result 
                WHERE  BYEAR=$cyear 
                AND PROVCODE=  '$provcode'
		        AND IDPROJECT=  '$pacode' ";
            
            
            $ppaname = Yii::$app->db->createCommand($sql_ppaname)->queryAll();
      
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
        }   
        
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
       
        if ($cyear == "2562") {

            $q_date = "SELECT MIN(d_com) AS d_com FROM s_pparesult WHERE byear=$cyear AND provcode=$provcode AND pacode='$pacode' ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];
            
            $sql_ppaname = "SELECT CONCAT(IDPROJECT,' : ',NAMEPROJECT)  AS ppaname FROM s_result_2562 WHERE IDPROJECT= '$pacode' ";
    

            $sql = "SELECT s_pparesult_2562.byear,s_pparesult_2562.hospcode,cmastercup.hsubname,s_pparesult_2562.result
                    FROM cmastercup 
                    INNER JOIN s_pparesult_2562 ON s_pparesult_2562.hospcode = cmastercup.hsub
                    WHERE s_pparesult_2562.byear = '$cyear' 
                    AND s_pparesult_2562.provcode = '$provcode'
                    AND cmastercup.hmain = '$hospcode'
                    AND s_pparesult_2562.pacode = '$pacode' 
                    ORDER BY s_pparesult_2562.result DESC ";
            
            $ppaname = Yii::$app->db->createCommand($sql_ppaname)->queryAll();
          
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data,
            ]);
        } else {
            
            $q_date = "SELECT MIN(d_com) AS d_com FROM s_pparesult WHERE byear=$cyear AND provcode=$provcode AND pacode='$pacode' ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];
            
            
            $sql_ppaname = "SELECT CONCAT(IDPROJECT,' : ',NAMEPROJECT)  AS ppaname FROM s_result WHERE IDPROJECT= '$pacode' ";
            
            $sql = "SELECT s_pparesult.byear,s_pparesult.hospcode,cmastercup.hsubname,s_pparesult.result
                    FROM cmastercup 
                    INNER JOIN s_pparesult ON s_pparesult.hospcode = cmastercup.hsub
                    WHERE s_pparesult.byear = '$cyear' 
                    AND s_pparesult.provcode = '$provcode'
                    AND cmastercup.hmain = '$hospcode'
                    AND s_pparesult.pacode = '$pacode' 
                    ORDER BY s_pparesult.result  DESC ";
            
            $ppaname = Yii::$app->db->createCommand($sql_ppaname)->queryAll();
        
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
        }   
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
