<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class ReportForm extends Model{
    
    public $byear;
    public $province;
    public $district;
    public $hospital;
    
    public function rules(){
        return [
            [['byear','province','district','hospital'], 'required']
        ];
    }

    public function attributeLabels(){
        return [
            'byear' => 'ปี',
            'province' => 'จังหวัด',
            'district' => 'อำเภอ/เขต',
            'hospital'=>'หน่วยบริการ'
        ];
    }

}
