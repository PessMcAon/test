<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_sub".
 *
 * @property string $project_sub_id
 * @property string $project_sub_detail
 * @property string $project_sub_name
 * @property string $subject_code
 * @property string $teacher_id
 *
 * @property Teacher $teacher
 * @property Subjects $subjectCode
 * @property ProjectSubStudent[] $projectSubStudents
 */
class ProjectSub extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_sub';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_sub_id', 'project_sub_detail', 'project_sub_name', 'subject_code', 'teacher_id'], 'required'],
            [['project_sub_id', 'subject_code'], 'string', 'max' => 11],
            [['project_sub_detail'], 'string', 'max' => 200],
            [['project_sub_name'], 'string', 'max' => 100],
            [['teacher_id'], 'string', 'max' => 20],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['teacher_id' => 'teacher_id']],
            [['subject_code'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['subject_code' => 'subjects_code']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_sub_id' => 'Project Sub ID',
            'project_sub_detail' => 'Project Sub Detail',
            'project_sub_name' => 'Project Sub Name',
            'subject_code' => 'Subject Code',
            'teacher_id' => 'Teacher ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(), ['teacher_id' => 'teacher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectCode()
    {
        return $this->hasOne(Subjects::className(), ['subjects_code' => 'subject_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectSubStudents()
    {
        return $this->hasMany(ProjectSubStudent::className(), ['project_sub_id' => 'project_sub_id']);
    }
}
