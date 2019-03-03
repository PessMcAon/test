<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_student_event".
 *
 * @property string $calendar_student_event_id
 * @property string $calendar_student_event_topic
 * @property string $calendar_student_event_date
 * @property string $calendar_student_event_detail
 * @property string $calendar_student_id
 *
 * @property CalendarStudent $calendarStudent
 */
class CalendarStudentEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_student_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_student_event_id', 'calendar_student_event_topic', 'calendar_student_event_date', 'calendar_student_event_detail', 'calendar_student_id'], 'required'],
            [['calendar_student_event_date'], 'safe'],
            [['calendar_student_event_id'], 'string', 'max' => 50],
            [['calendar_student_event_topic'], 'string', 'max' => 100],
            [['calendar_student_event_detail'], 'string', 'max' => 200],
            [['calendar_student_id'], 'string', 'max' => 20],
            [['calendar_student_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarStudent::className(), 'targetAttribute' => ['calendar_student_id' => 'calendar_student_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'calendar_student_event_id' => 'Calendar Student Event ID',
            'calendar_student_event_topic' => 'Calendar Student Event Topic',
            'calendar_student_event_date' => 'Calendar Student Event Date',
            'calendar_student_event_detail' => 'Calendar Student Event Detail',
            'calendar_student_id' => 'Calendar Student ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarStudent()
    {
        return $this->hasOne(CalendarStudent::className(), ['calendar_student_id' => 'calendar_student_id']);
    }
}
