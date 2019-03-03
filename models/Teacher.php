<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property string $teacher_id
 * @property string $teacher_prefix
 * @property string $teacher_firstName
 * @property string $teacher_lastName
 * @property string $teacher_email
 * @property string $teacher_line
 *
 * @property CalendarTeacher[] $calendarTeachers
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_id', 'teacher_prefix', 'teacher_firstName', 'teacher_lastName', 'teacher_email', 'teacher_line'], 'required'],
            [['teacher_id'], 'string', 'max' => 20],
            [['teacher_prefix', 'teacher_email'], 'string', 'max' => 50],
            [['teacher_firstName', 'teacher_lastName', 'teacher_line'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'teacher_id' => 'Teacher ID',
            'teacher_prefix' => 'Teacher Prefix',
            'teacher_firstName' => 'Teacher First Name',
            'teacher_lastName' => 'Teacher Last Name',
            'teacher_email' => 'Teacher Email',
            'teacher_line' => 'Teacher Line',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarTeachers()
    {
        return $this->hasMany(CalendarTeacher::className(), ['teacher_id' => 'teacher_id']);
    }
}
