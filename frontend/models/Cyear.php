<?php

namespace frontend\models;
use Yii;

/**
 * This is the model class for table "cyear".
 *
 * @property int $year_id
 * @property int $year_name
 */
class Cyear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cyear';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year_id'], 'required'],
            [['year_id', 'year_name'], 'integer'],
            [['year_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'year_id' => 'Year ID',
            'year_name' => 'Year Name',
        ];
    }

    public static function GetList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'year_name', 'year_name');
    }

    public static function getYearName($id)
    {
        if (($model = Cyear::findOne($id)) !== null) {
            return $model->year_name;
        } else {
            return '0000';
        }
    }
}
