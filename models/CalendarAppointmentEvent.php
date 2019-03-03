<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_appointment_event".
 *
 * @property string $calendar_appointment_event_id
 * @property string $calendar_appointment_event_topic
 * @property string $calendar_appointment_event_detail
 * @property string $calendar_appointment_event_date
 * @property string $calendar_appointment_id
 *
 * @property CalendarAppointment $calendarAppointment
 */
class CalendarAppointmentEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_appointment_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_appointment_event_id', 'calendar_appointment_event_topic', 'calendar_appointment_event_detail', 'calendar_appointment_event_date', 'calendar_appointment_id'], 'required'],
            [['calendar_appointment_event_date'], 'safe'],
            [['calendar_appointment_event_id'], 'string', 'max' => 50],
            [['calendar_appointment_event_topic'], 'string', 'max' => 100],
            [['calendar_appointment_event_detail'], 'string', 'max' => 200],
            [['calendar_appointment_id'], 'string', 'max' => 20],
            [['calendar_appointment_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarAppointment::className(), 'targetAttribute' => ['calendar_appointment_id' => 'calendar_appointment_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'calendar_appointment_event_id' => 'Calendar Appointment Event ID',
            'calendar_appointment_event_topic' => 'Calendar Appointment Event Topic',
            'calendar_appointment_event_detail' => 'Calendar Appointment Event Detail',
            'calendar_appointment_event_date' => 'Calendar Appointment Event Date',
            'calendar_appointment_id' => 'Calendar Appointment ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarAppointment()
    {
        return $this->hasOne(CalendarAppointment::className(), ['calendar_appointment_id' => 'calendar_appointment_id']);
    }
}
