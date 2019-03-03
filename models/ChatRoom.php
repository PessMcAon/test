<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat_room".
 *
 * @property string $chat_room_id
 * @property string $chat_date
 * @property string $project_id
 *
 * @property ChatMessage[] $chatMessages
 * @property Project $project
 */
class ChatRoom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chat_room_id', 'chat_date', 'project_id'], 'required'],
            [['chat_date'], 'safe'],
            [['chat_room_id'], 'string', 'max' => 30],
            [['project_id'], 'string', 'max' => 20],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chat_room_id' => 'Chat Room ID',
            'chat_date' => 'Chat Date',
            'project_id' => 'Project ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['chat_room_id' => 'chat_room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['project_id' => 'project_id']);
    }
}
