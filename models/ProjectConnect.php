<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_connect".
 *
 * @property string $project_connect_id
 * @property string $project_id
 * @property string $teacher_id
 * @property string $student_id
 * @property string $subjects_id
 */
class ProjectConnect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_connect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_connect_id', 'project_id', 'teacher_id', 'student_id', 'subjects_id'], 'required'],
            [['project_connect_id'], 'string', 'max' => 100],
            [['project_id', 'teacher_id'], 'string', 'max' => 20],
            [['student_id'], 'string', 'max' => 11],
            [['subjects_id'], 'string', 'max' => 45],
            [['project_connect_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_connect_id' => 'Project Connect ID',
            'project_id' => 'Project ID',
            'teacher_id' => 'Teacher ID',
            'student_id' => 'Student ID',
            'subjects_id' => 'Subjects ID',
        ];
    }
}
