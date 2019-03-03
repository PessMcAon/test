<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_university_editor".
 *
 * @property integer $calendar_university_editor_crby
 * @property string $calendar_university_editor
 * @property integer $calendar_university_editor_udby
 * @property string $calendar_university_editor_udtime
 * @property string $calendar_university_id
 *
 * @property CalendarUniversity $calendarUniversity
 */
class CalendarUniversityEditor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_university_editor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_university_editor_crby', 'calendar_university_editor', 'calendar_university_editor_udby', 'calendar_university_editor_udtime', 'calendar_university_id'], 'required'],
            [['calendar_university_editor_crby', 'calendar_university_editor_udby'], 'integer'],
            [['calendar_university_editor', 'calendar_university_editor_udtime'], 'safe'],
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
            'calendar_university_editor_crby' => 'Calendar University Editor Crby',
            'calendar_university_editor' => 'Calendar University Editor',
            'calendar_university_editor_udby' => 'Calendar University Editor Udby',
            'calendar_university_editor_udtime' => 'Calendar University Editor Udtime',
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
