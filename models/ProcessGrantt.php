<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_grantt".
 *
 * @property integer $process_grantt_id
 * @property string $process_grantt_topic
 * @property string $process_grantt_detail
 * @property string $process_grantt_date_start
 * @property string $process_grantt_date_end
 *
 * @property Process[] $processes
 */
class ProcessGrantt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_grantt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_grantt_id', 'process_grantt_topic', 'process_grantt_detail', 'process_grantt_date_start', 'process_grantt_date_end'], 'required'],
            [['process_grantt_id'], 'integer'],
            [['process_grantt_detail'], 'string'],
            [['process_grantt_date_start', 'process_grantt_date_end'], 'safe'],
            [['process_grantt_topic'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_grantt_id' => 'Process Grantt ID',
            'process_grantt_topic' => 'Process Grantt Topic',
            'process_grantt_detail' => 'Process Grantt Detail',
            'process_grantt_date_start' => 'Process Grantt Date Start',
            'process_grantt_date_end' => 'Process Grantt Date End',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesses()
    {
        return $this->hasMany(Process::className(), ['process_grantt_id' => 'process_grantt_id']);
    }
}
