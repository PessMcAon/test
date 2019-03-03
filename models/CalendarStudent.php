<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_student".
 *
 * @property string $calendar_student_id
 *
 * @property Student $calendarStudent
 * @property CalendarStudentEvent[] $calendarStudentEvents
 */
class CalendarStudent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_student_id'], 'required'],
            [['calendar_student_id'], 'string', 'max' => 20],
            [['calendar_student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['calendar_student_id' => 'calendar_student_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'calendar_student_id' => 'Calendar Student ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarStudent()
    {
        return $this->hasOne(Student::className(), ['calendar_student_id' => 'calendar_student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarStudentEvents()
    {
        return $this->hasMany(CalendarStudentEvent::className(), ['calendar_student_id' => 'calendar_student_id']);
    }
}
