<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requirement".
 *
 * @property integer $requirement_id
 * @property string $requirement_topic
 * @property string $requirement_detail
 * @property integer $requirement_status
 * @property integer $process_id
 *
 * @property Process $process
 * @property RequirementProgress[] $requirementProgresses
 */
class Requirement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requirement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requirement_topic', 'requirement_detail', 'requirement_status', 'process_id'], 'required'],
            [['requirement_detail'], 'string'],
            [['requirement_status', 'process_id'], 'integer'],
            [['requirement_topic'], 'string', 'max' => 100],
            [['process_id'], 'exist', 'skipOnError' => true, 'targetClass' => Process::className(), 'targetAttribute' => ['process_id' => 'process_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requirement_id' => 'Requirement ID',
            'requirement_topic' => 'Requirement Topic',
            'requirement_detail' => 'Requirement Detail',
            'requirement_status' => 'Requirement Status',
            'process_id' => 'Process ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcess()
    {
        return $this->hasOne(Process::className(), ['process_id' => 'process_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequirementProgresses()
    {
        return $this->hasMany(RequirementProgress::className(), ['requirement_id' => 'requirement_id']);
    }
}
