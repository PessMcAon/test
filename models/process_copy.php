<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process".
 *
 * @property string $process_id
 * @property string $project_id
 * @property string $process_gantt_tpye_code
 *
 * @property Project $project
 * @property ProcessProgress[] $processProgresses
 */
class Process extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id', 'project_id', 'process_gantt_tpye_code'], 'required'],
            [['process_id', 'process_gantt_tpye_code'], 'string', 'max' => 100],
            [['project_id'], 'string', 'max' => 20],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_id' => 'Process ID',
            'project_id' => 'Project ID',
            'process_gantt_tpye_code' => 'Process Gantt Tpye Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessProgresses()
    {
        return $this->hasMany(ProcessProgress::className(), ['process_id' => 'process_id']);
    }
}
