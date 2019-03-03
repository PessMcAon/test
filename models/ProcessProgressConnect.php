<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_progress_connect".
 *
 * @property string $process_progress_con_id
 * @property string $process_progress_id
 * @property string $process_progress_file_id
 *
 * @property ProcessProgressFile $processProgressFile
 * @property ProcessProgress $processProgress
 */
class ProcessProgressConnect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_progress_connect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_progress_con_id', 'process_progress_id', 'process_progress_file_id'], 'required'],
            [['process_progress_con_id'], 'string', 'max' => 100],
            [['process_progress_id'], 'string', 'max' => 50],
            [['process_progress_file_id'], 'string', 'max' => 200],
            [['process_progress_file_id'], 'unique'],
            [['process_progress_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessProgressFile::className(), 'targetAttribute' => ['process_progress_file_id' => 'process_progress_file_id']],
            [['process_progress_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessProgress::className(), 'targetAttribute' => ['process_progress_id' => 'process_progress_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_progress_con_id' => 'Process Progress Con ID',
            'process_progress_id' => 'Process Progress ID',
            'process_progress_file_id' => 'Process Progress File ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessProgressFile()
    {
        return $this->hasOne(ProcessProgressFile::className(), ['process_progress_file_id' => 'process_progress_file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessProgress()
    {
        return $this->hasOne(ProcessProgress::className(), ['process_progress_id' => 'process_progress_id']);
    }
}
