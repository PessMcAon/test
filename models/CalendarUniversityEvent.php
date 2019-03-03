<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_university_event".
 *
 * @property string $calendar_university_event_id
 * @property string $calendar_university_event_topic
 * @property string $calendar_university_event_detail
 * @property string $calendar_university_event_date
 * @property string $calendar_university_id
 *
 * @property CalendarUniversity $calendarUniversity
 */
class CalendarUniversityEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_university_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_university_event_id', 'calendar_university_event_topic', 'calendar_university_event_detail', 'calendar_university_event_date', 'calendar_university_id'], 'required'],
            [['calendar_university_event_date'], 'safe'],
            [['calendar_university_event_id'], 'string', 'max' => 50],
            [['calendar_university_event_topic'], 'string', 'max' => 100],
            [['calendar_university_event_detail'], 'string', 'max' => 200],
            [['calendar_university_id'], 'string', 'max' => 20],
            [['calendar_university_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarUniversity::className(), 'targetAttribute' => ['calendar_university_id' => 'calendar_university_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'calendar_university_event_id' => 'Calendar University Event ID',
            'calendar_university_event_topic' => 'Calendar University Event Topic',
            'calendar_university_event_detail' => 'Calendar University Event Detail',
            'calendar_university_event_date' => 'Calendar University Event Date',
            'calendar_university_id' => 'Calendar University ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarUniversity()
    {
        return $this->hasOne(CalendarUniversity::className(), ['calendar_university_id' => 'calendar_university_id']);
    }
}
