<?php

namespace frontend\models;

use Yii;
use frontend\models\UserRole;
use frontend\models\UserStatus;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            //[['username',  'password_hash', 'email'], 'required'],
            [['full_name'], 'required'],
            [['cid'], 'string', 'max' => 13],
            [['hospcode'], 'string', 'max' => 5],
            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32]
        ];
    }
    
    public function getUser_role(){
       return $this->hasOne(UserRole::className(), ['role_id' => 'role']);
    }
     public function getUser_status(){
       return $this->hasOne(UserStatus::className(), ['status_id' => 'status']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ไอดีผู้ใช้',
            'full_name' => 'ชื่อ-นามสกุล',
            'cid' => 'เลข 13 หลัก',
            'hospcode' => 'รหัสหน่วยบริการ',
            'username' => 'รหัสผู้ใช้งาน',
            'auth_key' => 'Auth Key',
            'password_hash' => 'รหัสผ่าน',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'อีเมล์',
            'role' => 'สิทธิใช้งาน',
            'status' => 'สถานะ',
            'created_at' => 'วันสมัคร',
            'updated_at' => 'วันอับเดท',
        ];
    }
}
