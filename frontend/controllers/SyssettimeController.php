<?php

namespace frontend\controllers;

use Yii;
use frontend\models\SysSetTime;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * SysSetTimeController implements the CRUD actions for SysSetTime model.
 */
class SyssettimeController extends Controller {


    public function behaviors(){
        
        $role = isset(Yii::$app->user->identity->role) ? Yii::$app->user->identity->role : 3;
        $arr = array();
        if ($role == 1) {
            $arr = ['index', 'view', 'create', 'update', 'delete',];
        } else {
            $arr = [''];
        }
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout', 'signup'],
                 'only' => ['index', 'view', 'create', 'update', 'delete'],
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


    public function actionIndex() {
       // $this->permitRole([1]);
        $dataProvider = new ActiveDataProvider([
            'query' => SysSetTime::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
       // $this->permitRole([1]);
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        //$this->permitRole([1]);
        $model = new SysSetTime();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
       // $this->permitRole([1]);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = SysSetTime::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
