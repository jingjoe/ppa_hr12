<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\db\Query;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

//AccessControl
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\models\LoginForm;

//Form Select 
use frontend\models\ReportForm;
use frontend\models\Province;
use frontend\models\District;
use frontend\models\Hospital;


class Report2Controller extends Controller{
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionIndex(){
        return $this->render('index');
    }
    
    public function actionRep01($cyear = NULL , $sepacode = NULL){
        
       $cyear = "2561";
            if (Yii::$app->request->isPost) {$cyear = $_POST['cyear'];
        }
                   
        $sepacode = "";
            if (Yii::$app->request->isPost) {$sepacode = $_POST['sepacode'];
        }

        $q_date = "SELECT IF(MIN(D_COM) IS NULL,'0000-00-00 00:00:00',MIN(D_COM)) AS d_com FROM ppa_s_result WHERE BYEAR=$cyear AND IDPROJECT='$sepacode' ";
        $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
        $date =  $sql_date['d_com'];
        
        $sql_ppaname = "SELECT CONCAT(IDPROJECT,' : ',NAMEPROJECT)  AS ppaname FROM ppa_s_result WHERE IDPROJECT= '$sepacode' ";
        $sql_ppacom = "SELECT IF(D_COM IS NULL,NOW(),MIN(D_COM)) AS d_com FROM ppa_s_result WHERE IDPROJECT= '$sepacode' ";
        
        $sql = "SELECT BYEAR,IDPROJECT,NAMEPROJECT,HOSPNAME,IF(D_COM IS NULL,NOW(),MIN(D_COM)) AS D_COM
                FROM ppa_s_result
                WHERE BYEAR=$cyear
                AND IDPROJECT LIKE '$sepacode%'
                GROUP BY IDPROJECT ";
        
        $ppaname = Yii::$app->db->createCommand($sql_ppaname)->queryAll();
        $ppacom = Yii::$app->db->createCommand($sql_ppacom)->queryAll();

        $data = Yii::$app->db->createCommand($sql)->queryAll();
        $dataProvider = new ArrayDataProvider([
            'allModels'=>$data,
            'pagination'=>[
            'pageSize'=>100 //แบ่งหน้า
            ]
        ]);
        return $this->render('rep01', [
                'cyear' =>$cyear,
                'ppaname' => $ppaname,
                'ppacom' => $ppacom,
                'pacode' => $sepacode,
                'date' =>  $date,
                'dataProvider' => $dataProvider]);
    }
    
    public function actionRep02(){
        
        $model = new ReportForm;
        
        $model->byear = date('Y')+543;
        $model->province = Yii::$app->params['province'];
        $model->district = Yii::$app->params['district'];
        $model->hospital = Yii::$app->params['hospital'];

    //POST
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $post = (object) Yii::$app->request->post('ReportForm');
            $model->byear = $post->byear;
            $model->province = $post->province;
            $model->district = $post->district;
            $model->hospital = $post->hospital;
        }

        $result = (object) $this->getSQLRep02($model);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $result->data,
            'pagination' => false,
        ]);

            return $this->render('rep02', [
            'model' => $model,
            'sql' => $result->sql,
            'sqlParams' => implode(', ', $result->cmd->params),
            'dataProvider' => $dataProvider,
            ]);
            

    }
  public function getSQLRep02($model)
    {
       $sql = "SELECT s.byear,c.hoscode,c.hosname,r.IDPROJECT,r.NAMEPROJECT,s.result,s.d_com
                FROM ppa_s_pparesult s
                INNER JOIN ppa_chospital c ON c.hoscode=s.hospcode
                INNER JOIN ppa_s_result r ON r.IDPROJECT=s.pacode
                WHERE  s.byear=:byear
                AND s.provcode=:province
                AND s.hospcode=:hospital
                GROUP BY s.hospcode ,s.pacode
                ORDER BY s.result DESC ";
        
        $conn = Yii::$app->db;
        $cmd = $conn->createCommand($sql);
        
        $cmd->bindValue(':byear', $model->byear);
        $cmd->bindValue(':province', $model->province);
        $cmd->bindValue(':hospital', $model->hospital);
        
        $data = $cmd->queryAll();

        return ['sql' => $sql, 'cmd' => $cmd, 'data' => $data];
    }
    
 // function เลือก จังหวัด อำเภอ หน่วยบริการ DepDrop 3 ตัวเลือก    
    public function actionGetAmphur() {
     $out = [];
     if (isset($_POST['depdrop_parents'])) {
         $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province = $parents[0];
                $out = $this->getDistrict($province);

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
     }
            echo Json::encode(['output'=>'', 'selected'=>'']);
 }

 
    public function actionGetHospital() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
                $ids = $_POST['depdrop_parents'];
                $province = empty($ids[0]) ? null : $ids[0];
                $district = empty($ids[1]) ? null : $ids[1];
            if ($province != null && $district != null) {
               
                $out = $this->getHospital($province,$district);
               
               //echo Json::encode(['output'=>$data, 'selected'=>'']);
               \Yii::$app->response->data = Json::encode(['output'=>$out, 'selected'=>'']);
               return;
            }
        }
                //echo Json::encode(['output'=>'', 'selected'=>'']);
                \Yii::$app->response->data = Json::encode(['output'=>$out, 'selected'=>'']);
    }

    protected function getDistrict($province){
        $datas = District::find()->where(['changwatcode'=>$province])->orderBy(['ampurcode' => SORT_ASC])->all();
        return $this->MapData($datas,'ampurcode','ampurname');
    }


    protected function getHospital($province,$district){
        $datas = Hospital::find()->where(['provcode'=>$province,'distcode'=>$district])->orderBy(['hoscode' => SORT_ASC])->all();
        return $this->MapData($datas,'hoscode','hosname');
    }

    protected function MapData($datas,$fieldId,$fieldName){
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id'=>$value->{$fieldId},'name'=>$value->{$fieldName}]);
        }
        return $obj;
    }
    
   
    
    public function actionRep03(){
        
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->role != 1) {
            $this->redirect(Yii::$app->urlManager->createAbsoluteUrl('site/login'));
        }
        
        $sql_date = Yii::$app->db->createCommand('SELECT d_send FROM ppa_s_pparesult')->queryOne();
        $date =  $sql_date['d_send'];
        
        $sql = "SELECT s.byear,c.hoscode,c.hosname,r.IDPROJECT,r.NAMEPROJECT,s.result,s.d_com
                FROM ppa_s_pparesult s
                INNER JOIN ppa_chospital c ON c.hoscode=s.hospcode
                INNER JOIN ppa_s_result r ON r.IDPROJECT=s.pacode
		GROUP BY s.hospcode ,s.pacode
                ORDER BY s.pacode ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();
        $dataProvider = new ArrayDataProvider([
            'allModels'=>$data,
            //'pagination'=>[
            //'pageSize'=>10 //แบ่งหน้า
            //]
        ]);
        return $this->render('rep03', [
                             'dataProvider' => $dataProvider,
                             'date' =>  $date]);
    }
    
    public function actionDetail1($byear=NULL,$pacode=NULL){
       
        $sql_ppaname = "SELECT CONCAT(IDPROJECT,' : ',NAMEPROJECT)  AS ppaname FROM ppa_s_result WHERE IDPROJECT= '$pacode' ";
        $sql_ppacom = "SELECT IF(D_COM IS NULL,NOW(),MIN(D_COM)) AS d_com FROM ppa_s_result WHERE IDPROJECT= '$pacode' ";
        
        $sql_detail1 = "SELECT s.byear,c.hoscode,c.hosname,r.IDPROJECT,r.NAMEPROJECT,s.result,s.d_com
                        FROM ppa_s_pparesult s
                        INNER JOIN ppa_chospital c ON c.hoscode=s.hospcode
                        INNER JOIN ppa_s_result r ON r.IDPROJECT=s.pacode
                        WHERE  s.byear=$byear
                        AND s.pacode='$pacode'
			GROUP BY s.hospcode ,s.pacode
                        ORDER BY s.result DESC ";
        
        $ppaname = Yii::$app->db->createCommand($sql_ppaname)->queryAll();
        $ppacom = Yii::$app->db->createCommand($sql_ppacom)->queryAll();
        
        $data1 = Yii::$app->db->createCommand($sql_detail1)->queryAll();

        $dataProvider = new ArrayDataProvider([
            'allModels'=>$data1,
            'pagination'=>[
            'pageSize'=>1000 //แบ่งหน้า
        ]
        ]);
        return $this->render('detail1', [
                    'dataProvider' => $dataProvider,
                    'ppaname' => $ppaname,
                    'ppacom' => $ppacom,
                    'pacode' => $pacode,
                    'byear' => $byear]);
    }
   
}
