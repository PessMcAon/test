<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_add".
 *
 * @property string $process_add_id
 * @property string $process_add_topic
 * @property string $process_add_detail
 * @property string $process_add_date_start
 * @property string $process_add_date_end
 *
 * @property ProcessAddCannect $processAddCannect
 */
class ProcessAdd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_add';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_add_id', 'process_add_topic', 'process_add_detail', 'process_add_date_start', 'process_add_date_end'], 'required'],
            [['process_add_detail'], 'string'],
            [['process_add_date_start', 'process_add_date_end'], 'safe'],
            [['process_add_id'], 'string', 'max' => 50],
            [['process_add_topic'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_add_id' => 'Process Add ID',
            'process_add_topic' => 'Process Add Topic',
            'process_add_detail' => 'Process Add Detail',
            'process_add_date_start' => 'Process Add Date Start',
            'process_add_date_end' => 'Process Add Date End',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessAddCannect()
    {
        return $this->hasOne(ProcessAddCannect::className(), ['process_add_id' => 'process_add_id']);
    }
}
