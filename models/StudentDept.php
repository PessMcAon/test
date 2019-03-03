<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_dept".
 *
 * @property integer $student_dept_id
 * @property string $student_dept_name
 *
 * @property Student[] $students
 */
class StudentDept extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_dept';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_dept_id', 'student_dept_name'], 'required'],
            [['student_dept_id'], 'integer'],
            [['student_dept_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_dept_id' => 'Student Dept ID',
            'student_dept_name' => 'Student Dept Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['student_dept_id' => 'student_dept_id']);
    }
}
