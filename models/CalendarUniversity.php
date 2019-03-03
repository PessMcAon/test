<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_university".
 *
 * @property string $calendar_university_id
 *
 * @property CalendarUniversityEditor[] $calendarUniversityEditors
 * @property CalendarUniversityEvent[] $calendarUniversityEvents
 */
class CalendarUniversity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_university';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_university_id'], 'required'],
            [['calendar_university_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'calendar_university_id' => 'Calendar University ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarUniversityEditors()
    {
        return $this->hasMany(CalendarUniversityEditor::className(), ['calendar_university_id' => 'calendar_university_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarUniversityEvents()
    {
        return $this->hasMany(CalendarUniversityEvent::className(), ['calendar_university_id' => 'calendar_university_id']);
    }
}
