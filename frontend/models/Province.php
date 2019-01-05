<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property string $changwatcode
 * @property string $changwatname
 * @property string $zonecode
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ppa_province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['changwatcode'], 'required'],
            [['changwatcode', 'zonecode'], 'string', 'max' => 2],
            [['changwatname'], 'string', 'max' => 255],
            [['changwatcode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'changwatcode' => 'Changwatcode',
            'changwatname' => 'Changwatname',
            'zonecode' => 'Zonecode',
        ];
    }
    
      public function getDistrict()
    {
        return $this->hasMany(District::className(), ['changwatcode' => 'ampurcode']);
    }
}
