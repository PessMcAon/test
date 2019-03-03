<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personnel".
 *
 * @property string $personnel_id
 * @property string $personnel_name
 * @property string $personnel_lastname
 * @property string $personnel_email
 */
class Personnel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personnel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['personnel_id', 'personnel_name', 'personnel_lastname', 'personnel_email'], 'required'],
            [['personnel_id'], 'string', 'max' => 50],
            [['personnel_name', 'personnel_lastname'], 'string', 'max' => 200],
            [['personnel_email'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'personnel_id' => 'Personnel ID',
            'personnel_name' => 'Personnel Name',
            'personnel_lastname' => 'Personnel Lastname',
            'personnel_email' => 'Personnel Email',
        ];
    }
}
