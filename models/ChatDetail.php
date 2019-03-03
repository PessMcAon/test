<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat_detail".
 *
 * @property integer $chat_id
 * @property string $chat_name
 * @property string $chat_message
 * @property string $chat_message_date
 * @property string $chat_room_id
 *
 * @property ChatRoom $chatRoom
 */
class ChatDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chat_name', 'chat_message', 'chat_message_date', 'chat_room_id'], 'required'],
            [['chat_message'], 'string'],
            [['chat_name'], 'string', 'max' => 100],
            [['chat_message_date'], 'string', 'max' => 50],
            [['chat_room_id'], 'string', 'max' => 30],
            [['chat_room_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatRoom::className(), 'targetAttribute' => ['chat_room_id' => 'chat_room_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
            'chat_name' => 'Chat Name',
            'chat_message' => 'Chat Message',
            'chat_message_date' => 'Chat Message Date',
            'chat_room_id' => 'Chat Room ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatRoom()
    {
        return $this->hasOne(ChatRoom::className(), ['chat_room_id' => 'chat_room_id']);
    }
}
