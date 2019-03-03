<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "process_gantt_type".
 *
 * @property string $process_gantt_tpye_id
 * @property string $process_gantt_tpye_code
 * @property string $subjects_id
 *
 * @property Subjects $subjects
 */
class ProcessGanttType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'process_gantt_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_gantt_tpye_id', 'process_gantt_tpye_code', 'subjects_id'], 'required'],
            [['process_gantt_tpye_id'], 'string', 'max' => 200],
            [['process_gantt_tpye_code'], 'string', 'max' => 100],
            [['subjects_id'], 'string', 'max' => 45],
            [['subjects_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['subjects_id' => 'subjects_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_gantt_tpye_id' => 'Process Gantt Tpye ID',
            'process_gantt_tpye_code' => 'Process Gantt Tpye Code',
            'subjects_id' => 'Subjects ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasOne(Subjects::className(), ['subjects_id' => 'subjects_id']);
    }
}
