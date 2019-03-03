<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subjects".
 *
 * @property string $subjects_id
 * @property string $subjects_code
 * @property string $subjects_name_thai
 * @property string $subjects_name_eng
 * @property string $subject_year
 * @property integer $subject_semester
 * @property integer $student_degree_id
 */
class Subjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subjects_id', 'subjects_code', 'subjects_name_thai', 'subjects_name_eng', 'subject_year', 'subject_semester', 'student_degree_id'], 'required'],
            [['subject_year'], 'safe'],
            [['subject_semester', 'student_degree_id'], 'integer'],
            [['subjects_id'], 'string', 'max' => 45],
            [['subjects_code'], 'string', 'max' => 11],
            [['subjects_name_thai', 'subjects_name_eng'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subjects_id' => 'Subjects ID',
            'subjects_code' => 'Subjects Code',
            'subjects_name_thai' => 'Subjects Name Thai',
            'subjects_name_eng' => 'Subjects Name Eng',
            'subject_year' => 'Subject Year',
            'subject_semester' => 'Subject Semester',
            'student_degree_id' => 'Student Degree ID',
        ];
    }
}
