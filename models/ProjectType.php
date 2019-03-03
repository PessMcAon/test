<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_type".
 *
 * @property integer $project_type_id
 * @property string $project_type_code
 * @property string $project_type_name_eng
 * @property string $project_type_name_thai
 *
 * @property Project[] $projects
 */
class ProjectType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_type_id', 'project_type_code', 'project_type_name_eng', 'project_type_name_thai'], 'required'],
            [['project_type_id'], 'integer'],
            [['project_type_code'], 'string', 'max' => 20],
            [['project_type_name_eng', 'project_type_name_thai'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_type_id' => 'Project Type ID',
            'project_type_code' => 'Project Type Code',
            'project_type_name_eng' => 'Project Type Name Eng',
            'project_type_name_thai' => 'Project Type Name Thai',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['project_type_id' => 'project_type_id']);
    }
}
