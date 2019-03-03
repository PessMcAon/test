<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "progress".
 *
 * @property integer $progress_id
 * @property string $progress_file
 * @property string $progress_date
 * @property integer $requirement_id
 *
 * @property Requirement $requirement
 */
class Progress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'progress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['progress_file', 'progress_date', 'requirement_id'], 'required'],
            [['progress_date'], 'safe'],
            [['requirement_id'], 'integer'],
            [['progress_file'], 'string', 'max' => 200],
            [['requirement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Requirement::className(), 'targetAttribute' => ['requirement_id' => 'requirement_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'progress_id' => 'Progress ID',
            'progress_file' => 'Progress File',
            'progress_date' => 'Progress Date',
            'requirement_id' => 'Requirement ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequirement()
    {
        return $this->hasOne(Requirement::className(), ['requirement_id' => 'requirement_id']);
    }
}
