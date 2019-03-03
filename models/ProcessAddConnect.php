<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_add_connect".
 *
 * @property string $process_add_connect_id
 * @property string $process_progress_id
 * @property string $process_add_id
 *
 * @property ProcessProgress $processProgress
 * @property ProcessAdd $processAdd
 */
class ProcessAddConnect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_add_connect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_add_connect_id', 'process_progress_id', 'process_add_id'], 'required'],
            [['process_add_connect_id'], 'string', 'max' => 100],
            [['process_progress_id'], 'string', 'max' => 45],
            [['process_add_id'], 'string', 'max' => 50],
            [['process_progress_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessProgress::className(), 'targetAttribute' => ['process_progress_id' => 'process_progress_id']],
            [['process_add_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessAdd::className(), 'targetAttribute' => ['process_add_id' => 'process_add_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_add_connect_id' => 'Process Add Connect ID',
            'process_progress_id' => 'Process Progress ID',
            'process_add_id' => 'Process Add ID',
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
    public function getProcessAdd()
    {
        return $this->hasOne(ProcessAdd::className(), ['process_add_id' => 'process_add_id']);
    }
}
