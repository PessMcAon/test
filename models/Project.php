<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property string $project_id
 * @property string $project_name_th
 * @property string $project_name_en
 * @property string $project_detail
 * @property integer $project_progress
 *
 * @property CalendarAppointment[] $calendarAppointments
 * @property ChatRoom[] $chatRooms
 * @property Process[] $processes
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'project_name_th', 'project_name_en', 'project_detail', 'project_progress'], 'required'],
            [['project_detail'], 'string'],
            [['project_progress'], 'integer'],
            [['project_id'], 'string', 'max' => 20],
            [['project_name_th', 'project_name_en'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'project_name_th' => 'Project Name Th',
            'project_name_en' => 'Project Name En',
            'project_detail' => 'Project Detail',
            'project_progress' => 'Project Progress',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarAppointments()
    {
        return $this->hasMany(CalendarAppointment::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatRooms()
    {
        return $this->hasMany(ChatRoom::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesses()
    {
        return $this->hasMany(Process::className(), ['project_id' => 'project_id']);
    }
}
