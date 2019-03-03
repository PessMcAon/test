<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property string $student_id
 * @property string $student_prefix
 * @property string $student_firstName
 * @property string $student_lastName
 * @property integer $student_gender
 * @property string $student_email
 * @property string $student_line
 * @property integer $student_degree_id
 * @property integer $student_dept_id
 *
 * @property CalendarStudent[] $calendarStudents
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'student_prefix', 'student_firstName', 'student_lastName', 'student_gender', 'student_email', 'student_line', 'student_degree_id', 'student_dept_id'], 'required'],
            [['student_gender', 'student_degree_id', 'student_dept_id'], 'integer'],
            [['student_id'], 'string', 'max' => 11],
            [['student_prefix', 'student_email', 'student_line'], 'string', 'max' => 50],
            [['student_firstName', 'student_lastName'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_id' => 'Student ID',
            'student_prefix' => 'Student Prefix',
            'student_firstName' => 'Student First Name',
            'student_lastName' => 'Student Last Name',
            'student_gender' => 'Student Gender',
            'student_email' => 'Student Email',
            'student_line' => 'Student Line',
            'student_degree_id' => 'Student Degree ID',
            'student_dept_id' => 'Student Dept ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarStudents()
    {
        return $this->hasMany(CalendarStudent::className(), ['student_id' => 'student_id']);
    }
}
