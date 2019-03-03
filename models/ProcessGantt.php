<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_gantt".
 *
 * @property string $process_gantt_id
 * @property integer $process_gantt_no
 * @property string $process_gantt_topic
 * @property string $process_gantt_detail
 * @property integer $process_gantt_score
 * @property string $process_gantt_date_start
 * @property string $process_gantt_date_end
 * @property string $process_gantt_type_code
 */
class ProcessGantt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_gantt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_gantt_id', 'process_gantt_no', 'process_gantt_topic', 'process_gantt_detail', 'process_gantt_score', 'process_gantt_date_start', 'process_gantt_date_end', 'process_gantt_type_code'], 'required'],
            [['process_gantt_no', 'process_gantt_score'], 'integer'],
            [['process_gantt_detail'], 'string'],
            [['process_gantt_date_start', 'process_gantt_date_end'], 'safe'],
            [['process_gantt_id', 'process_gantt_type_code'], 'string', 'max' => 200],
            [['process_gantt_topic'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_gantt_id' => 'Process Gantt ID',
            'process_gantt_no' => 'Process Gantt No',
            'process_gantt_topic' => 'Process Gantt Topic',
            'process_gantt_detail' => 'Process Gantt Detail',
            'process_gantt_score' => 'Process Gantt Score',
            'process_gantt_date_start' => 'Process Gantt Date Start',
            'process_gantt_date_end' => 'Process Gantt Date End',
            'process_gantt_type_code' => 'Process Gantt Type Code',
        ];
    }
}
