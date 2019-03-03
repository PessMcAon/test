<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ChatDetail;


$session = Yii::$app->session;
$session->remove('sesValue');


/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */

Yii::$app->view->params['title'] = 'Project List'

?>

<link href="<?= Yii::$app->homeUrl ?>assets/css/chat.css" rel="stylesheet" type="text/css"/> <!-- css ของ chat -->


<section id="middle">
    <header id="page-header">
            <h1>Messenger</h1>
            <ol class="breadcrumb">
                <li><a href="javascript:history.back(1)">รายละเอียดของโครงงาน</a></li>
                <li class="active">Messenger</li>
            </ol>

    </header>

    <div class="top_menu">
        <div class="buttons">
            <div class="button close"></div>
            <div class="button minimize"></div>
            <div class="button maximize"></div>
        </div>
        <div class="title"><?= $project ?></div>
    </div>

    <ul class="messages"><?php include("chat_msg.php"); ?></ul> <!-- ดึงหน้า chat_msg.php มาแสดงในกล่องแชท chat_msg.php คือข้อความของ user -->
    <div class="bottom_wrapper clearfix">
        <div class="message_input_wrapper"><input class="message_input" placeholder="Type your message here..."/></div>
        <div class="send_message">
            <div class="icon"></div>
            <div class="text">Send</div>
        </div>
    </div>

    <div class="message_template">
        <li class="message">
            <div class="avatar"></div>
            <div class="text_wrapper">
                <div class="text"></div>
            </div>
        </li>
    </div>

</section>


<script>
    (function () {
        var Message;
        var last_id;

        Message = function (arg) {
            this.text = arg.text, this.message_side = arg.message_side;
            this.draw = function (_this) {
                return function () {
                    var $message;
                    $message = $($('.message_template').clone().html());
                    $message.addClass(_this.message_side).find('.text').html(_this.text);
                    $('.messages').append($message);
                    return setTimeout(function () {
                        return $message.addClass('appeared');
                    }, 0);
                };
            }(this);
            return this;
        };


        $(function () {
            $('.messages').animate({scrollTop: $('.messages').prop('scrollHeight')}, 0);
            var getMessageText, message_side, sendMessage;
            message_side = 'left';
            getMessageText = function () {
                var $message_input;
                $message_input = $('.message_input');
                return $message_input.val();
            };

            sendMessage = function (text,type) {
                var $messages, message;
                if (text.trim() === '') {
                    return;
                }
                if(type == 1) {
                    $('.message_input').val('');
                    $messages = $('.messages');
                    message_side = 'right';
                    message = new Message({
                        text: text,
                        message_side: message_side
                    });
                }
                message.draw();
                return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 0);

            };

            //--------------------------------------------------------------------------------------------------
            // รับค่าข้อความจาก user  แล้วส่งไปที่ controller chat ตรงฟังค์ชัน chat_send

            $('.send_message').click(function (e) {
                $.post('<?= Yii::$app->homeUrl ?>chat/chat_send', {msg: getMessageText()}, function () {});
                return sendMessage(getMessageText(),1);
            });
            $('.message_input').keyup(function (e) {
                if (e.which === 13) {
                    $.post('<?= Yii::$app->homeUrl ?>chat/chat_send', {msg: getMessageText()}, function () {});
                    return sendMessage(getMessageText(),1);
                }
            });

            //----------------------------------------------------------------------------

            //----------------------------------------------------------------------------
            // ดึงข้อความจาก DB มาแสดงในแชท ทุกๆ 1 วินาที
            setInterval(function () {
//                $('.messages').load('<?//= Yii::$app->homeUrl ?>//chat/chat_msg');

                $.get('<?= Yii::$app->homeUrl ?>/chat/chat_msg', function (data) {
                    data = JSON.parse(data);
                    $('.messages').html(data["msg"]);
                    if(data['last_id'] != last_id) {
                        $('.messages').animate({scrollTop: $('.messages').prop('scrollHeight')}, 0);
                    }
                    last_id = data['last_id'];
                });
            },1000); // 1000 คือเวลาที่จะให้กล่องแชทรีโหลด 1000 = 1 วินาที
        });

    }.call(this));
</script>