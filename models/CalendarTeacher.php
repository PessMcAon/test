<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_teacher".
 *
 * @property string $calendar_teacher_id
 *
 * @property Teacher $calendarTeacher
 * @property CalendarTeacherEvent[] $calendarTeacherEvents
 */
class CalendarTeacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_teacher_id'], 'required'],
            [['calendar_teacher_id'], 'string', 'max' => 20],
            [['calendar_teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['calendar_teacher_id' => 'calendar_teacher_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'calendar_teacher_id' => 'Calendar Teacher ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarTeacher()
    {
        return $this->hasOne(Teacher::className(), ['calendar_teacher_id' => 'calendar_teacher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarTeacherEvents()
    {
        return $this->hasMany(CalendarTeacherEvent::className(), ['calendar_teacher_id' => 'calendar_teacher_id']);
    }
}
