<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_gantt_connect".
 *
 * @property string $process_gantt_connect_id
 * @property string $process_progress_id
 * @property string $process_gantt_id
 *
 * @property ProcessProgress $processProgress
 * @property ProcessGantt $processGantt
 */
class ProcessGanttConnect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_gantt_connect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_gantt_connect_id', 'process_progress_id', 'process_gantt_id'], 'required'],
            [['process_gantt_connect_id'], 'string', 'max' => 100],
            [['process_progress_id'], 'string', 'max' => 45],
            [['process_gantt_id'], 'string', 'max' => 50],
            [['process_progress_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessProgress::className(), 'targetAttribute' => ['process_progress_id' => 'process_progress_id']],
            [['process_gantt_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessGantt::className(), 'targetAttribute' => ['process_gantt_id' => 'process_gantt_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_gantt_connect_id' => 'Process Gantt Connect ID',
            'process_progress_id' => 'Process Progress ID',
            'process_gantt_id' => 'Process Gantt ID',
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
    public function getProcessGantt()
    {
        return $this->hasOne(ProcessGantt::className(), ['process_gantt_id' => 'process_gantt_id']);
    }
}
