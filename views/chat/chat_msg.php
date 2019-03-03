<?php
if(isset($chat_msg)) {
    foreach ($chat_msg as $item): // วนลูปรับข้อความทั้งหมดใน DB
        if ($item['chat_name'] == $session->get('pfc_name')) {
            $type = "right";
            echo "<div style='margin-bottom: 5px; margin-right: 10px; color:#969696;' align='right'>{$item['chat_name']}</div><li class='message $type appeared'><div class='avatar'></div><div class='text_wrapper'><div class='text'>{$item['chat_message']}</div></div></li>";
        } else {
            $type = "left";
            echo "<div style='margin-bottom: 5px; margin-left: 10px; color:#969696;' align='left'  >{$item['chat_name']}</div><li class='message $type appeared'><div class='avatar'></div><div class='text_wrapper'><div class='text'>{$item['chat_message']}</div></div></li>";
        }
    endforeach;
}