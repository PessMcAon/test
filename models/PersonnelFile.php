<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personnel_file".
 *
 * @property string $personnel_file_id
 * @property string $personnel_file_name
 * @property string $personnel_file_pro
 * @property string $personnel_file_date
 */
class PersonnelFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personnel_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['personnel_file_id', 'personnel_file_name', 'personnel_file_pro', 'personnel_file_date'], 'required'],
            [['personnel_file_date'], 'safe'],
            [['personnel_file_id'], 'string', 'max' => 100],
            [['personnel_file_name', 'personnel_file_pro'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'personnel_file_id' => 'Personnel File ID',
            'personnel_file_name' => 'Personnel File Name',
            'personnel_file_pro' => 'Personnel File Pro',
            'personnel_file_date' => 'Personnel File Date',
        ];
    }
}
