<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_requirement".
 *
 * @property string $process_requirement_id
 * @property string $process_requirement_topic
 * @property string $process_requirement_detail
 * @property integer $process_requirement_status
 * @property string $process_progress_id
 *
 * @property ProcessProgress $processProgress
 * @property ProcessRequirementConnect[] $processRequirementConnects
 * @property ProcessProgressFile[] $processProgressFiles
 */
class ProcessRequirement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_requirement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_requirement_id', 'process_requirement_topic', 'process_requirement_detail', 'process_requirement_status', 'process_progress_id'], 'required'],
            [['process_requirement_status'], 'integer'],
            [['process_requirement_id'], 'string', 'max' => 50],
            [['process_requirement_topic', 'process_requirement_detail'], 'string', 'max' => 200],
            [['process_progress_id'], 'string', 'max' => 45],
            [['process_progress_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessProgress::className(), 'targetAttribute' => ['process_progress_id' => 'process_progress_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_requirement_id' => 'Process Requirement ID',
            'process_requirement_topic' => 'Process Requirement Topic',
            'process_requirement_detail' => 'Process Requirement Detail',
            'process_requirement_status' => 'Process Requirement Status',
            'process_progress_id' => 'Process Progress ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessProgress()
    {
        return $this->hasOne(ProcessProgress::className(), ['process_progress_id' => 'process_progress_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessRequirementConnects()
    {
        return $this->hasMany(ProcessRequirementConnect::className(), ['process_requirement_id' => 'process_requirement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessProgressFiles()
    {
        return $this->hasMany(ProcessProgressFile::className(), ['process_progress_file_id' => 'process_progress_file_id'])->viaTable('process_requirement_connect', ['process_requirement_id' => 'process_requirement_id']);
    }
}
