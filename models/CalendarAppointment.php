<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_appointment".
 *
 * @property string $calendar_appointment_id
 * @property string $project_id
 *
 * @property Project $project
 * @property CalendarAppointmentEvent[] $calendarAppointmentEvents
 */
class CalendarAppointment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_appointment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_appointment_id', 'project_id'], 'required'],
            [['calendar_appointment_id', 'project_id'], 'string', 'max' => 20],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'calendar_appointment_id' => 'Calendar Appointment ID',
            'project_id' => 'Project ID',
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
    public function getCalendarAppointmentEvents()
    {
        return $this->hasMany(CalendarAppointmentEvent::className(), ['calendar_appointment_id' => 'calendar_appointment_id']);
    }
}
