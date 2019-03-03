<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_progress".
 *
 * @property string $process_progress_id
 * @property integer $process_progress_no
 * @property double $process_progress_score
 * @property double $process_progress_score_full
 * @property double $process_progress_per_full
 * @property double $process_progress_per
 * @property string $process_id
 * @property integer $process_progress_status_id
 *
 * @property ProcessAddConnect[] $processAddConnects
 * @property Process $process
 * @property ProcessProgressConnect[] $processProgressConnects
 * @property ProcessProgressFile[] $processProgressFiles
 * @property ProcessRequirement[] $processRequirements
 */
class ProcessProgress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_progress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_progress_id', 'process_progress_no', 'process_progress_score', 'process_progress_score_full', 'process_progress_per_full', 'process_progress_per', 'process_id', 'process_progress_status_id'], 'required'],
            [['process_progress_no', 'process_progress_status_id'], 'integer'],
            [['process_progress_score', 'process_progress_score_full', 'process_progress_per_full', 'process_progress_per'], 'number'],
            [['process_progress_id'], 'string', 'max' => 45],
            [['process_id'], 'string', 'max' => 20],
            [['process_id'], 'exist', 'skipOnError' => true, 'targetClass' => Process::className(), 'targetAttribute' => ['process_id' => 'process_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_progress_id' => 'Process Progress ID',
            'process_progress_no' => 'Process Progress No',
            'process_progress_score' => 'Process Progress Score',
            'process_progress_score_full' => 'Process Progress Score Full',
            'process_progress_per_full' => 'Process Progress Per Full',
            'process_progress_per' => 'Process Progress Per',
            'process_id' => 'Process ID',
            'process_progress_status_id' => 'Process Progress Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessAddConnects()
    {
        return $this->hasMany(ProcessAddConnect::className(), ['process_progress_id' => 'process_progress_id']);
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
    public function getProcessProgressConnects()
    {
        return $this->hasMany(ProcessProgressConnect::className(), ['process_progress_id' => 'process_progress_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessProgressFiles()
    {
        return $this->hasMany(ProcessProgressFile::className(), ['process_progress_file_id' => 'process_progress_file_id'])->viaTable('process_progress_connect', ['process_progress_id' => 'process_progress_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessRequirements()
    {
        return $this->hasMany(ProcessRequirement::className(), ['process_progress_id' => 'process_progress_id']);
    }
}
