<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;


use yii\db\Query;
use yii\data\ArrayDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($cyear = NULL , $provcode = NULL)
    {
        
        $cyear = "2561";
            if (Yii::$app->request->isPost) {$cyear = $_POST['cyear'];
        }
                   
        $provcode = "01";
            if (Yii::$app->request->isPost) {$provcode = $_POST['provcode'];
        }
       
     
        if ($cyear == "2562") {
            
            $q_date = "SELECT IF(MIN(D_COM) IS NULL,'0000-00-00 00:00:00',MIN(D_COM)) AS d_com FROM s_result_2562 WHERE BYEAR=$cyear AND PROVCODE=$provcode ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];

            $sql = "SELECT IDPROJECT,NAMEPROJECT,IF(D_COM IS NULL,NOW(),MIN(D_COM)) AS D_COM
                    FROM s_result_2562
                    WHERE PROVCODE=$provcode
                    AND BYEAR=$cyear
                    GROUP BY IDPROJECT ";

            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data,
            ]);
        } else {
            
            $q_date = "SELECT IF(MIN(D_COM) IS NULL,'0000-00-00 00:00:00',MIN(D_COM)) AS d_com FROM s_result WHERE BYEAR=$cyear AND PROVCODE=$provcode ";
            $sql_date = Yii::$app->db->createCommand($q_date)->queryOne();
            $date =  $sql_date['d_com'];

            $sql = "SELECT IDPROJECT,NAMEPROJECT,IF(D_COM IS NULL,NOW(),MIN(D_COM)) AS D_COM
                    FROM s_result
                    WHERE PROVCODE=$provcode
                    AND BYEAR=$cyear
                    GROUP BY IDPROJECT ";

            $data = Yii::$app->db->createCommand($sql)->queryAll();
            $dataProvider = new ArrayDataProvider([
                'allModels'=>$data
            ]);
        }   
       
        return $this->render('index', [
            'dataProvider' => $dataProvider, 
            'cyear' => $cyear,
            'date' =>  $date,
            'provcode' => $provcode]);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            $username = $model->username;
            $ip = \Yii::$app->getRequest()->getUserIP();

            $sql = " INSERT INTO `user_log` (`username`,`login_date`, `ip`) VALUES ('$username',NOW(), '$ip') ";
            \Yii::$app->db->createCommand($sql)->execute();
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
	public function actionPopup(){
        return $this->renderAjax('popup');
    }
}
