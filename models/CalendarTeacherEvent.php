<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_teacher_event".
 *
 * @property string $calendar_teacher_event_id
 * @property string $calendar_teacher_event_topic
 * @property string $calendar_teacher_event_detail
 * @property string $calendar_teacher_event_date
 * @property string $calendar_teacher_id
 *
 * @property CalendarTeacher $calendarTeacher
 */
class CalendarTeacherEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_teacher_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_teacher_event_id', 'calendar_teacher_event_topic', 'calendar_teacher_event_detail', 'calendar_teacher_event_date', 'calendar_teacher_id'], 'required'],
            [['calendar_teacher_event_date'], 'safe'],
            [['calendar_teacher_event_id'], 'string', 'max' => 50],
            [['calendar_teacher_event_topic'], 'string', 'max' => 100],
            [['calendar_teacher_event_detail'], 'string', 'max' => 200],
            [['calendar_teacher_id'], 'string', 'max' => 20],
            [['calendar_teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarTeacher::className(), 'targetAttribute' => ['calendar_teacher_id' => 'calendar_teacher_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'calendar_teacher_event_id' => 'Calendar Teacher Event ID',
            'calendar_teacher_event_topic' => 'Calendar Teacher Event Topic',
            'calendar_teacher_event_detail' => 'Calendar Teacher Event Detail',
            'calendar_teacher_event_date' => 'Calendar Teacher Event Date',
            'calendar_teacher_id' => 'Calendar Teacher ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarTeacher()
    {
        return $this->hasOne(CalendarTeacher::className(), ['calendar_teacher_id' => 'calendar_teacher_id']);
    }
}
