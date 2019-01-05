<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hospital".
 *
 * @property string $hoscode
 * @property string $hosname
 * @property string $hostype
 * @property string $subdistcode
 * @property string $distcode
 * @property string $provcode

 */
class Hospital extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ppa_hospital';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hoscode'], 'required'],
            [['hosname'], 'string', 'max' => 255],
            [['hostype','subdistcode', 'distcode', 'provcode'], 'string', 'max' => 2],
            [['hoscode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hoscode' => 'Hoscode',
            'hosname' => 'Hosname',
            'hostype' => 'Hostype',
            'subdistcode' => 'Subdistcode',
            'distcode' => 'Distcode',
            'provcode' => 'Provcode',
            'postcode' => 'Postcode'
        ];
    }
    
  
}
