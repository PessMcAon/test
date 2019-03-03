<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_requirement_connect".
 *
 * @property string $process_requirement_con_id
 * @property string $process_requirement_id
 * @property string $process_progress_file_id
 *
 * @property ProcessRequirement $processRequirement
 * @property ProcessProgressFile $processProgressFile
 */
class ProcessRequirementConnect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_requirement_connect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_requirement_con_id', 'process_requirement_id', 'process_progress_file_id'], 'required'],
            [['process_requirement_con_id'], 'string', 'max' => 100],
            [['process_requirement_id'], 'string', 'max' => 50],
            [['process_progress_file_id'], 'string', 'max' => 200],
            [['process_requirement_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessRequirement::className(), 'targetAttribute' => ['process_requirement_id' => 'process_requirement_id']],
            [['process_progress_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessProgressFile::className(), 'targetAttribute' => ['process_progress_file_id' => 'process_progress_file_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_requirement_con_id' => 'Process Requirement Con ID',
            'process_requirement_id' => 'Process Requirement ID',
            'process_progress_file_id' => 'Process Progress File ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessRequirement()
    {
        return $this->hasOne(ProcessRequirement::className(), ['process_requirement_id' => 'process_requirement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessProgressFile()
    {
        return $this->hasOne(ProcessProgressFile::className(), ['process_progress_file_id' => 'process_progress_file_id']);
    }
}
