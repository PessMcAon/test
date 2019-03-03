<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_sub_student".
 *
 * @property string $project_sub_id
 * @property string $student_id
 *
 * @property ProjectSub $projectSub
 */
class ProjectSubStudent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_sub_student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_sub_id', 'student_id'], 'required'],
            [['project_sub_id', 'student_id'], 'string', 'max' => 11],
            [['project_sub_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectSub::className(), 'targetAttribute' => ['project_sub_id' => 'project_sub_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_sub_id' => 'Project Sub ID',
            'student_id' => 'Student ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectSub()
    {
        return $this->hasOne(ProjectSub::className(), ['project_sub_id' => 'project_sub_id']);
    }
}
