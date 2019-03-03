<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_progress_file".
 *
 * @property string $process_progress_file_id
 * @property string $process_progress_file_name
 * @property string $process_progress_file_progress
 * @property string $process_progress_file_date
 * @property integer $process_progress_file_persontype
 *
 * @property ProcessProgressConnect[] $processProgressConnects
 * @property ProcessProgress[] $processProgresses
 * @property ProcessRequirementConnect[] $processRequirementConnects
 * @property ProcessRequirement[] $processRequirements
 */
class ProcessProgressFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_progress_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_progress_file_id', 'process_progress_file_name', 'process_progress_file_progress', 'process_progress_file_date', 'process_progress_file_persontype'], 'required'],
            [['process_progress_file_date'], 'safe'],
            [['process_progress_file_persontype'], 'integer'],
            [['process_progress_file_id', 'process_progress_file_progress'], 'string', 'max' => 200],
            [['process_progress_file_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_progress_file_id' => 'Process Progress File ID',
            'process_progress_file_name' => 'Process Progress File Name',
            'process_progress_file_progress' => 'Process Progress File Progress',
            'process_progress_file_date' => 'Process Progress File Date',
            'process_progress_file_persontype' => 'Process Progress File Persontype',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessProgressConnects()
    {
        return $this->hasMany(ProcessProgressConnect::className(), ['process_progress_file_id' => 'process_progress_file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessProgresses()
    {
        return $this->hasMany(ProcessProgress::className(), ['process_progress_id' => 'process_progress_id'])->viaTable('process_progress_connect', ['process_progress_file_id' => 'process_progress_file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessRequirementConnects()
    {
        return $this->hasMany(ProcessRequirementConnect::className(), ['process_progress_file_id' => 'process_progress_file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessRequirements()
    {
        return $this->hasMany(ProcessRequirement::className(), ['process_requirement_id' => 'process_requirement_id'])->viaTable('process_requirement_connect', ['process_progress_file_id' => 'process_progress_file_id']);
    }
}
