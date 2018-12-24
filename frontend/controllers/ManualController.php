<?php
namespace frontend\controllers;
use yii\web\Controller;
use yii\db\Query;
use Yii;
use yii\data\ArrayDataProvider;

class ManualController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }
    
    public function actionKeyppahis() {
        return $this->render('keyppahis');
    }

    public function actionFittest() {
        return $this->render('fittest');
    }
    
    public function actionKeyfittest100() {
        return $this->render('keyfittest100');
    }
    
    public function actionEppa62() {
        return $this->render('ppa62');
    }
    
    public function actionTosmartkids() {
        return $this->render('tosmartkids');
    }



}
