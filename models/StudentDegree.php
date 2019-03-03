<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_degree".
 *
 * @property integer $student_degree_id
 * @property string $student_degree_name
 *
 * @property Student[] $students
 * @property Subjects[] $subjects
 */
class StudentDegree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_degree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_degree_id', 'student_degree_name'], 'required'],
            [['student_degree_id'], 'integer'],
            [['student_degree_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_degree_id' => 'Student Degree ID',
            'student_degree_name' => 'Student Degree Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['student_degree_id' => 'student_degree_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subjects::className(), ['student_degree_id' => 'student_degree_id']);
    }
}
