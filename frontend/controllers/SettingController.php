<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SettingController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
