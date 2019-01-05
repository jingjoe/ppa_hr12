<?php

namespace frontend\models;

use Yii;

use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

use yii\filters\AccessControl;
use common\models\User;

class Ppafile extends \yii\db\ActiveRecord{
    const DOC_PATH = 'ppafile';

    public static function tableName() {
        return 'ppa_file';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['detail'], 'string'],
            [['hits', 'created_by', 'updated_by'], 'integer'],
            [['create_date', 'modify_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['token_upload'], 'string', 'max' => 100],
            [['files'], 'file'] //extensions' => 'cds,txt,sql'
        ];
        
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_date',
                'updatedAtAttribute' => 'modify_date',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ชื่อไฟล์',
            'detail' => 'รายละเอียด',
            'files' => 'แนบไฟล์',
            'token_upload' => 'Token Upload',
            'hits' => 'จำนวนโหลด',
            'create_date' => 'วันอัพโหลด',
            'modify_date' => 'วันอับเดท',
            'created_by' => 'บันทึกโดย',
            'updated_by' => 'อับเดทโดย',
            
        // เพิ่มฟิวล์ใหม่ จาก funtion get  relation          
            'loginname' => 'ชื่อผู้บันทึก',
            'updatename' => 'ชื่อผู้อับเดท',
            'programname' => 'โปรแกรม',
            'download' => ''
        ];
    }
// get ชื่อผู้บันทึก
    public function getLogin() {
        return @$this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getLoginname() {
        return @$this->login->username;
    }

// get ชื่อผู้อับเดท
    public function getUpdate() {
        return @$this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getUpdatename() {
        return @$this->update->username;
    }

// Function upload files.

    public static function getDocPath() {
        return Yii::getAlias('@webroot') . '/' . self::DOC_PATH;
    }

    public static function getDocUrl() {
        return Url::base(true) . '/' . self::DOC_PATH;
    }
}
