<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Ppafile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

// Add upload
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\helpers\Html;
use yii\helpers\Url;

// AccessControl
use yii\filters\AccessControl;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\models\LoginForm;

/**
 * ProgramsController implements the CRUD actions for Programs model.
 */
class PpafileController extends Controller{
    
    public function behaviors(){
        
        $role = isset(Yii::$app->user->identity->role) ? Yii::$app->user->identity->role : 3;
        $arr = array();
        if ($role != 3) {
            $arr = ['index', 'index2','view', 'create', 'update', 'delete',];
        } else {
            $arr = [''];
        }
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout', 'signup'],
                 'only' => ['index', 'indexs2','view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => $arr,
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => $arr,
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    

    /**
     * Lists all Programs models.
     * @return mixed
     */
    public function actionIndex()
    {
         if (Yii::$app->user->isGuest || Yii::$app->user->identity->role == 3) {
            $this->redirect(Yii::$app->urlManager->createAbsoluteUrl('site/login'));
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Ppafile::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIndex2()
    {
          if (Yii::$app->user->isGuest || Yii::$app->user->identity->role != 1) {
            $this->redirect(Yii::$app->urlManager->createAbsoluteUrl('site/login'));
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Ppafile::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                'id' => SORT_DESC,
                //'create_date' => SORT_ASC, 
                ]
            ],
        ]);

        return $this->render('index2', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Programs model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Programs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new Ppafile();
        $model->token_upload = substr(Yii::$app->getSecurity()->generateRandomString(), 10);

        if ($model->load(Yii::$app->request->post())) {

            //  $this->Uploads(false);

            $model->files = UploadedFile::getInstance($model, 'files');

            if ($model->files && $model->validate()) {
                $fileName = ($model->files->baseName .'_'. time()) . '.' . $model->files->extension;
                $image = $model->files;
                $model->files = $fileName;
                $image->saveAs('ppafile/' . $fileName);
                if ($model->save()) {
                     return $this->redirect('index.php?r=ppafile/index');
                }
                } else if ($model->save()) {
                    return $this->redirect('index.php?r=ppafile/index');
                }
        }

        return $this->render('create', [
                    'model' => $model
        ]);
 
    }

    /**
     * Updates an existing Programs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $tempResume = $model->files;

        if ($model->load(Yii::$app->request->post())) {

            //$this->Uploads(false);

            $model->files = UploadedFile::getInstance($model, 'files');
            if ($model->files && $model->validate()) {
                $fileName = ($model->files->baseName .'_'. time()) . '.' . $model->files->extension;
                $image = $model->files;
                $model->files = $fileName;
                $image->saveAs('ppafile/' . $fileName);
                if ($model->save()) {
                   return $this->redirect('index.php?r=ppafile/index');
                }
            } else {
                $model->files = $tempResume;
                if ($model->save()) {
                    return $this->redirect('index.php?r=ppafile/index');

                }
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
        
    }

    /**
     * Deletes an existing Programs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Programs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Programs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ppafile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    // รับค่ามาจาก from เพื่อ ดาวน์โหลด 
    public function actionDownload($type, $id) {
        $model = $this->findModel($id);
        if ($type === 'files') {
            Yii::$app->response->sendFile($model->getDocPath() . '/' . $model->files);
            $model->hits +=1; // นับจำนวนดาวน์โหลด
            $model->save();
        }
    }
    

}
