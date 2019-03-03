<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Student;
use app\models\Teacher;


$session = Yii::$app->session;


/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */

Yii::$app->view->params['title'] = 'Project List';
$email = '1133';
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>

    <meta charset='utf-8'/>
    <link href='<?= Yii::$app->homeUrl ?>assets/fullcalendar.min.css' rel='stylesheet'/>
    <link href='<?= Yii::$app->homeUrl ?>assets/fullcalendar.print.min.css' rel='stylesheet' media='print'/>
    <script src='<?= Yii::$app->homeUrl ?>assets/moment.min.js'></script>
    <script src='<?= Yii::$app->homeUrl ?>assets/jquery.min.js'></script>
    <script src='<?= Yii::$app->homeUrl ?>assets/fullcalendar.min.js'></script>
    <script src='<?= Yii::$app->homeUrl ?>assets/jquery.datepair.min.js'></script>
    <script src='<?= Yii::$app->homeUrl ?>assets/datepair.min.js'></script>
    <script src="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.css"/>
    <script
            src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
            integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
            crossorigin="anonymous"></script>

    <style>


        body {

            margin: 0px 0px;
            padding: 0;
            font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
            font-size: 14px;

        }

        #calendar {
            position: absolute;
            width: 75%;
            /*max-width: 900px;*/
            margin-left: 250px;
            margin-bottom 100px;
        }

        #list {
            position: absolute;
            width: 235px;
            margin-left: 10px;
            margin-top: 10px;
        }

        #event {
            position absolute;
            width 10%;
            margin-left: 10px;
            margin-top: 10px;
        }

        #calendar, #list {
            float: left;

        }

        .rcorners2 {
            border-radius: 10px;
            border: 2px solid #73AD21;
            padding: 10px;
        }

        .rcorners3 {
            text-align: center;
            border-radius: 10px;
            border: 2px solid #73AD21;
            padding: 10px;
            width: 235px;
            height: auto;
            background-color: yellow;
        }

        .rcorners4 {
            border-radius: 10px;
            border: 2px solid #73AD21;
            background-color: yellow;
            width: 100%;
            padding: 4px;
        }

    </style>
    <section id="middle">
        <div class="padding-20">
            <div class="row">

                <?php
                $session = Yii::$app->session;
                if($session->get('pfc_id') != null){
                    $teacher = Teacher::find()->where("teacher_id like :b", [":b" => $session->get('pfc_id')])->all();
                    $student = Student::find()->where("student_id like :b", [":b" => $session->get('pfc_id')])->all();
//                    $personnel = $Personnel::find()->where("personnel_id like :b", [":b" => $session->get('pfc_id')])->all();

                    if($teacher != null){
                        $email = $teacher[0]->teacher_email;
                    }elseif($student != null){
                        $email = $student[0]->student_email;
                    }
//                    else if($personnel != null){
//                        $email = $personnel[0]->personnel_email;
//                    }
                }
                ?>

                <button id="sign-in-or-out-button" class='btn btn-success'
                        style="margin-left: 25px">Sign In
                </button>

                <button id="revoke-access-button" class='btn btn-danger' hidden
                        style="display: none; margin-left: 25px">Sign Out
                </button>
                <button type="button" id="insert" class="btn btn-success" hidden
                        style="display: none; margin-left:30px">สมัครรับข้อมูลจากปฏิทินอื่น</button>
                <button type='button' id='qwe' class='btn btn-success' data-dismiss='modal' style="display: none;margin-left:31px">
                    สร้างกลุ่มข้อมูลปฏิทิน
                </button>
                <br>





                <a href="../../../../controllers/GGController.php?email=test@gmail.com">

                </a>

                <button id="user2"
                        style="margin-left: 25px"></button>


                <?php
                echo '';
                ?>
                <div id="eee" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modal-body">
                            <span>กรอก ID ของปฏิทิน : ตัวอย่าง Nawakorn.kao@gmail.com </span>
                            <br>
                            <br>
                            <input type='text' id='cid'/>
                            <br>
                            <br>
                            <button type='button' id='Sub' class='btn btn-success' data-dismiss='modal'>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
                <div id="www" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modal-body">
                            <span>ชื่อปฏิทิน</span>
                            <input type='text' id='summa'/>
                            <br>
                            <br>
                            <span>email อาจารย์ </span>
                            <input type='text' id = 'em1' />
                            <br>
                            <br>
                            <span>email นักศึกษาคนที่ 1</span>
                            <input type='text' id='em2'/>
                            <br>
                            <span>email นักศึกษาคนที่ 2</span>
                            <input type='text' id='em3'/>
                            <br>
                            <span>email นักศึกษาคนที่ 3</span>
                            <input type='text' id='em4'/>
                            <br>
                            <br>
                            <button type='button' id='con' class='btn btn-success' data-dismiss='modal'>
                                Simulate
                            </button>
                        </div>
                    </div>
                </div>

                <div id="calendarModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modal-body">
                            <span>สร้างปฏิทิน</span>
                            <div id="event">
                                หัวข้อ
                                <input type="text" id="summary"/>
                                เลือกปฏิทินที่ต้องการ
                                <select id="cal_select">
                                </select>
                                <div id="mytime"><br/> เลือกช่วงเวลา
                                    <input type='text' id='mytime_start' class='time start'/> to
                                    <input type='text' id='mytime_end' class='time end'/>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('body').on('hidden.bs.modal', '.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                </script>

                <div id="selfModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modal-body">
                            <span>ข้อมูลปฏิทิน</span>
                            <div id="modal-detailself-lul"></div>

                            <button type='button' id='delete1' class='btn btn-danger' data-dismiss='modal'>
                                ลบกิจกรรมนี้
                            </button>
                        </div>
                    </div>
                </div>

                <div id="detailModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modal-body">
                            <span>ข้อมูลปฏิทิน</span>
                            <div id="modal-detail-lul"></div>

                            <span>สถานะ :<font color="#00008b">ยังไม่ตัดสินใจ</font></span>
                            <div>
                                <button type='button' id='cancelled' class='btn btn-danger' data-dismiss='modal'>ปฏิเสธ
                                </button>
                                <button type='button' id='accept' class='btn btn-success' data-dismiss='modal'>ยอมรับ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="detailModalnormal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modal-body">
                            <span>ข้อมูลปฏิทิน</span>
                            <div id="modal-normal-lul"></div>
                        </div>
                    </div>
                </div>


                <div id="detailModal2" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modal-body">
                            <span>ข้อมูลปฏิทิน</span>
                            <div id="modal-detail2-lul"></div>
                            <span>สถานะ :<font color="blue">ยังไม่ติดสินใจ</font></span>
                            <div>
                                <button type='button' id='cancelled2' class='btn btn-danger' data-dismiss='modal'>
                                    ยกเลิกการนัดหมาย
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="accepted" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modal-body">
                            <span>ข้อมูลปฏิทิน</span>
                            <div id="modal-accepted-lul"></div>
                            <span>สถานะ :<font color="green">ยืนยันแล้ว</font></span>
                        </div>
                    </div>
                </div>

                <div id="cancelledModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modal-body">
                            <span>ข้อมูลปฏิทิน</span>
                            <div id="modal-cancel-lul"></div>
                            <!--                            <div id="test1"></div>-->
                            <!--                            <div id="test2"></div>-->
                            <!--                            <div>จากช่วง-->
                            <!--                                <span id="test3"></span> ถึง-->
                            <!--                                <span id="test4"></span>-->
                            <!--                            </div>-->
                            <span>สถานะ : <font color="red">ปฏิเสธ</font></span>
                            <button type='button' id='delete2' class='btn btn-danger' data-dismiss='modal'>
                                ลบการนัดหมายนี้ถาวร
                            </button>

                        </div>

                    </div>
                </div>


            </div>

            <div id="buffet-pls" class="hidden">
                ชื่อหัวข้อ : <span class="title-xd"></span><br>
                รายละเอียด : <span class="description-xd"></span>
                <div> จากช่วง
                    <span class="time-start-xd">  </span> ถึง
                    <span class="time-end-xd"></span>
                </div>
            </div>

            <div id="ggez" class="row invisible">
                <label class="rcorners3" style="margin-left: 10px">ปฏิทินทั้งหมด</label><br>
                <div class="col-md-4 rcorners2" id="list">
                </div>
                <div class="col-md-8" id='calendar'>
                    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
                    <script async defer src="https://apis.google.com/js/api.js"
                            onload="this.onload=function(){};handleClientLoad()"
                            onreadystatechange="if (this.readyState === 'complete') this.onload()">
                    </script>

                    <script type='text/javascript' src='<?= Yii::$app->homeUrl ?>assets/gcal.js'></script>
                </div>
            </div>
        </div>

    </section>
</head>



<script>
    $(document).ready(function () {
        $("#mytime").append("<br><p style='margin-bottom: 0px;'>รายละเอียด</p> <textarea cols='50' style='margin-top: 10px;margin-bottom: 10px;' id='description'></textarea><br>" +
            "<button type='button' id='close' class='btn btn-danger' data-dismiss='modal'>Close</button> " +
            "<button type='button' id='create' class='btn btn-success' data-dismiss='modal'>Create</button>");
    });

</script>
<script>
    var user = {};
    var GoogleAuth;
    var SCOPE = 'https://www.googleapis.com/auth/calendar';

    var CAL_ID_XD = null;
    var EVENT_ID_XD = null;
    var START_XD = null;
    var END_XD = null;
    var SUMMARY_XD = null;
    var DESCRIPTION_XD = null;
    var EmailComp1 = null;
    var EmailComp2 = null;
    var cid = null;
    var em1 = null;
    var em2=null;
    var em3=null;
    var em4=null;
    var day=null;
    var Tday=null;
    var Wday=null;
    var REMINDER_XD =null;
    var email_check = "<?php Print($email); ?>";
    var buffet_pls2=null;
    var mailIns_check=null;


    function handleClientLoad() {
        // Load the API's client and auth2 modules.
        // Call the initClient function after the modules load.
        gapi.load('client:auth2', initClient);
    }

    function initClient() {

        // Retrieve the discovery document for version 3 of Google Drive API.
        // In practice, your app can retrieve one or more discovery documents.
//        var discoveryUrl = 'https://www.googleapis.com/discovery/v1/apis/drive/v3/rest';
        var discoveryUrl = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';

        // Initialize the gapi.client object, which app uses to make API requests.
        // Get API key and client ID from API Console.
        // 'scope' field specifies space-delimited list of access scopes.
        gapi.client.init({

            'apiKey': 'AIzaSyCg2nd4tlvs3xGu4ugXIRu_Hmzn6mBpWrQ',
            'discoveryDocs': [discoveryUrl],
            'clientId': '6316704372-3vifm1qd136c29ujbop9g0ubdfvg6n43.apps.googleusercontent.com',
            'scope': SCOPE
        }).then(function () {
            GoogleAuth = gapi.auth2.getAuthInstance();

            // Listen for sign-in state changes.
            GoogleAuth.isSignedIn.listen(updateSigninStatus);
            //listUpcomingEvents();

            // Handle initial sign-in state. (Determine if user is already signed in.)
            user = GoogleAuth.currentUser.get();
            setSigninStatus();


            // Call handleAuthClick function when user clicks on
            //      "Sign In/Authorize" button.
            $('#sign-in-or-out-button').click(function () {
                handleAuthClick();
            });
            $('#revoke-access-button').click(function () {
                revokeAccess();
            });
        });
    }

    function handleAuthClick() {
        if (GoogleAuth.isSignedIn.get()) {

            // User is authorized and has clicked 'Sign out' button.
            GoogleAuth.signOut();
        } else {
            // User is not signed in. Start Google auth flow.
            GoogleAuth.signIn();
        }
    }

    function revokeAccess() {
        GoogleAuth.disconnect();
        location.reload();

    }


    function Delete(calId) {
        var request = gapi.client.calendar.calendarList.delete({
            'calendarId': calId,
        });

        request.execute(function(resp) {
            if (typeof resp.code === 'undefined') {
                alert("Calendar was successfully removed!");
                location.reload();
            }else{
                alert('An error occurred... Error code: '+ resp.code +' - Message: '+resp.message);
            }

        });



    }

    function privaterole(calId) {
        request = gapi.client.calendar.acl.update({
            calendarId: calId,
            ruleId: 'default',
            scope: {
                type: "default"
            },
            role: "freeBusyReader",

        });


        request.execute(function (calendar) {
            location.reload()
//            console.log(calId)

        })
    }
    document.getElementById('accept').onclick = function () {
        request = gapi.client.calendar.events.update({
            calendarId: CAL_ID_XD,
            ruleId: 'default',
            eventId: EVENT_ID_XD,
            "start": {
                "dateTime": START_XD
            },
            "end": {
                "dateTime": END_XD
            },
            status: "confirmed",
            summary: SUMMARY_XD + "(✔)",
            description: DESCRIPTION_XD,
            "reminders": {
                "overrides": [
                    {
                        "method": "email",
                        "minutes": 1
                    },
                    {
                        "method": "email",
                        "minutes": 1440
                    }
                ],
                "useDefault": false
            }
        });

        request.execute(function (calendar) {
            location.reload();
        })
    };

    document.getElementById('cancelled').onclick = function () {
        request = gapi.client.calendar.events.update({
            calendarId: CAL_ID_XD,
            ruleId: 'default',
            eventId: EVENT_ID_XD,
            "start": {
                "dateTime": START_XD
            },
            "end": {
                "dateTime": END_XD
            },
            status: "tentative",
            summary: SUMMARY_XD + "(✘)",
            description: DESCRIPTION_XD
        });
        request.execute(function (calendar) {
            console.log(status)
            location.reload()
        })
    };
    document.getElementById('cancelled2').onclick = function () {
        request = gapi.client.calendar.events.update({
            calendarId: CAL_ID_XD,
            ruleId: 'default',
            eventId: EVENT_ID_XD,
            "start": {
                "dateTime": START_XD
            },
            "end": {
                "dateTime": END_XD
            },
            status: "tentative",
            summary: SUMMARY_XD + "(✘)",
            description: DESCRIPTION_XD
        });
        request.execute(function (calendar) {
            console.log(status);
            location.reload()
        })
    };

    document.getElementById('delete1').onclick = function () {
        var request = gapi.client.calendar.events.delete({
            calendarId: CAL_ID_XD,
            ruleId: 'default',
            eventId: EVENT_ID_XD
        });
        request.execute(function (calendar) {
            console.log(calendar)
            location.reload();
        })
    };
    document.getElementById('delete2').onclick = function () {
        var request = gapi.client.calendar.events.delete({
            calendarId: CAL_ID_XD,
            ruleId: 'default',
            eventId: EVENT_ID_XD
        });
        request.execute(function (calendar) {
            console.log(calendar)
            location.reload();
        })
    };
    document.getElementById('insert').onclick = function () {
        $('#eee').modal();
    };
    document.getElementById('Sub').onclick = function () {
        cid = $('#cid').val();
        console.log(cid)

        var request = gapi.client.calendar.calendarList.insert({
            "id": cid,
            colorRgbFormat: true
        });


        request.execute(function(resp) {
            if (typeof resp.code === 'undefined') {
                alert("Calendar was successfully subscribed!");
                location.reload();
            }else{
                alert('An error occurred... Error code: '+ resp.code +' - Message: '+resp.message);
            }

        });
        // }else {
        //     alert("กรุณากรอก Gmail ให้ตรงกับคำแนะนำ");
        // }

    };



    document.getElementById('qwe').onclick = function () {
        $('#www').modal();
    };
    document.getElementById('con').onclick = function () {
        em1 =  $('#em1').val();
        em2 =  $('#em2').val();
        em3 =  $('#em3').val();
        em4 =  $('#em4').val();
        summa = $('#summa').val();

        console.log(em2,em1,summa)
        var request = gapi.client.calendar.calendars.insert({
            summary: summa,
            'timeZone': 'Asia/Bangkok',
        });

        request.execute(function (calendar) {
            if (em1=! null) {
                request = gapi.client.calendar.acl.insert({
                    calendarId: calendar.id,
                    role: "owner",
                    scope: {
                        type: "group",
                        value: em1
                    },
                });
                request.execute(function (resp) {
                    if (typeof resp.code === 'undefined') {}else
                    {alert('Email อาจารย์ ข้อมูลผิดพลาด')
                        mailIns_check = 1;
                    }
                });
            }
            request.execute(function (calendar) {
            });
            if (em2=!null) {
                request = gapi.client.calendar.acl.insert({
                    calendarId: calendar.id,
                    role: "owner",
                    scope: {
                        type: "group",
                        value: em2
                    },
                });
                request.execute(function (resp) {
                    if (typeof resp.code === 'undefined') {}else
                    {alert('Email นศ. 1 ข้อมูลผิดพลาด')
                        mailIns_check = 1
                    }
                });
            }
            request.execute(function (calendar) {
            });
            if (em3 = !null) {
                request = gapi.client.calendar.acl.insert({
                    calendarId: calendar.id,
                    role: "owner",
                    scope: {
                        type: "group",
                        value: em3
                    },
                });
                request.execute(function (resp) {
                    if (typeof resp.code === 'undefined') {}else
                    {alert('Email นศ. 2 ข้อมูลผิดพลาด')
                        mailIns_check = 1
                    }
                });
            }

            if (em4 = !null) {
                request = gapi.client.calendar.acl.insert({
                    calendarId: calendar.id,
                    role: "owner",
                    scope: {
                        type: "group",
                        value: em4
                    },
                });
                request.execute(function (resp) {
                    if (typeof resp.code === 'undefined') {}else
                    {alert('Email นศ. 3 ข้อมูลผิดพลาด')
                        mailIns_check = 1
                    }
                });
            }
            var request = gapi.client.calendar.acl.insert({
                calendarId: calendar.id,
                rule: "public",
                scope: {
                    type: "default"
                },
                role: "reader"
            });
            // var request = gapi.client.calendar.calendarList.delete({
            //     'calendarId': calId,
            // });



            request.execute(function (calendar) {
            })
        });
    };


    $('#mytime .time').timepicker({
        'showDuration': true,
        'timeFormat': 'H:i'
    });


    $('#mytime').datepair();


    ////////fix role////////


    /////////INSERT NEW CALENDAR////////
    document.getElementById('xqc').onclick = function () {
        console.log(gapi)

        var summa = prompt('กรอกชื่อปฏิทิน');
        var request = gapi.client.calendar.calendars.insert({
            summary: summa,
            'timeZone': 'Asia/Bangkok',
        });

        request.execute(function (calendar) {

            request = gapi.client.calendar.acl.insert({
                calendarId: calendar.id,
                rule: "public",
                scope: {
                    type: "default"
                },
                role: "reader"
            });

            request.execute(function (calendar) {
                console.log(calendar)
//                                location.reload();
            })

            // console.log(calendar);

        });

        console.log(5555)
    }


    ////////CALENDAR////////
    function calendar(ARRAY) {
//                        console.log(gapi.client.calendar.calendarList.get)
        $('#calendar').fullCalendar({
            googleCalendarApiKey: 'AIzaSyCg2nd4tlvs3xGu4ugXIRu_Hmzn6mBpWrQ',
            selectable: true,
            selectHelper: true,
            eventLimit: true,
            header: {
                left: 'prev,next Calendar',
                center: 'title',
                right: 'listDay,listWeek,listMonth,month'
            },
            views: {
                listDay:{ buttonText: 'List Day' },
                listWeek: { buttonText: 'List Week' },
                listMonth: { buttonText: 'List Month' },
                month: {buttonText: 'Calendar'},
            },

            ////Event Detail////
            eventClick: function (Event,ARRAY,Calendar) {


                $('.title-xd').html(Event.title);
                $('.description-xd').html(Event.description);
                $('.time-start-xd').html(moment(new Date(Event.start)).format('HH:mm'));
                $('.time-end-xd').html(moment(new Date(Event.end)).format('HH:mm'));


                // $('#time-remind-xd').html(Event.reminders);

                CAL_ID_XD = Event.source.googleCalendarId;
                EVENT_ID_XD = Event.id;
                START_XD = Event.start._i;
                END_XD = Event.end._i;
                SUMMARY_XD = Event.title;
                DESCRIPTION_XD = Event.description;

                // REMINDER_XD = Event.reminders;
                var buffet_pls = $('#buffet-pls').html();



                if (Event.title.endsWith('(✔)')) {
                    $('#modal-accepted-lul').html(buffet_pls);
                    $('#accepted').modal();
                } else if (CAL_ID_XD.includes('holiday')) {
                } else if (Event.title.endsWith('(✘)')) {
                    $('#modal-cancel-lul').html(buffet_pls);
                    $('#cancelledModal').modal();

                } else if (CAL_ID_XD == EmailComp1) {
                    $('#modal-detailself-lul').html(buffet_pls);
                    $('#selfModal').modal();
                } else if (Event.source.googleCalendarId.includes('@group.calendar')){
                    if (Event.description.endsWith(EmailComp1)) {
                        $('#modal-detail2-lul').html(buffet_pls);
                        $('#detailModal2').modal();
                    } else if(Event.source.ajaxSettings.summary.includes('csc')){
                        $('#modal-detail-lul').html(buffet_pls);
                        $('#detailModal').modal();
                    } else if(Event.source.ajaxSettings.summary.includes('CSC')){
                        $('#modal-detail-lul').html(buffet_pls);
                        $('#detailModal').modal();
                    } else if(Event.source.ajaxSettings.summary.includes('ict')){
                        $('#modal-detail-lul').html(buffet_pls);
                        $('#detailModal').modal();
                    } else if(Event.source.ajaxSettings.summary.includes('ICT')){
                        $('#modal-detail-lul').html(buffet_pls);
                        $('#detailModal').modal();
                    } else if(Event.source.ajaxSettings.summary.includes('gis')){
                        $('#modal-detail-lul').html(buffet_pls);
                        $('#detailModal').modal();
                    } else if(Event.source.ajaxSettings.summary.includes('GIS')){
                        $('#modal-detail-lul').html(buffet_pls);
                        $('#detailModal').modal();
                    }else {
                        $('#modal-normal-lul').html(buffet_pls);
                        $('#detailModalnormal').modal();
                    }
                } else  {
                    $('#modal-normal-lul').html(buffet_pls);
                    $('#detailModalnormal').modal();
                }



                // console.log(buffet_pls)
                // change the border color just for fun
                $(this).css('border-color', 'red');

                return false;

            },
            ////////create event //////////
            select: function (start, end, discription, jsEvent, view) {
                $(".modal").on("calendarModal", function(){
                    $(".calendarModal").html("");
                });
                $('#calendarModal').modal();
                $('#create').click(function () {
                    startts = $('#mytime_start').val();
                    endte = $('#mytime_end').val();
                    calId = $('#cal_select').find(':selected').val();
                    description = $('#description').val();
                    summary = $('#summary').val();
                    Emails = EmailComp1;
                    var event = {

                        'summary': summary,
                        'description': description + "      ผู้สร้าง : " + Emails,
                        'start': {
                            'dateTime': moment(start).format() + "T" + startts + ":00",
                            'timeZone': 'Asia/Bangkok',
                        },
                        'end': {
                            'dateTime': moment(start).format() + "T" + endte + ":00",
                            'timeZone': 'Asia/Bangkok',
                        },
                        'status': "tentative",
                        "reminders": {
                            "overrides": [
                                {
                                    "method": "email",
                                    "minutes": 1
                                },
                                //             {
                                //                 "method": "email",
                                //                 "minutes": 1440
                                //             },
                                //             if(Tday == "1"){
                                //     {
                                //         "method": "email",
                                //         "minutes": 4320
                                //     },
                                // }
                                //             if(Wday == "1"){
                                //     {
                                //         "method": "email",
                                //         "minutes": 10080
                                //     },
                                // }
                            ],
                            "useDefault": false
                        }

                    };


//                                console.log(user.w3.U3);

                    var request = gapi.client.calendar.events.insert({

                        'calendarId': calId,
                        'resource': event,

                    });


                    request.execute(function (resp,event) {
                        if (typeof resp.code === 'undefined') {
                            alert("สร้างข้อมูลสำเร็จ");
                            location.reload();
                        }else{
                            alert("ผิดพลาดในการสร้างข้อมูล โปรดตรวจสอบปฏิทินที่เลือก");
                            location.reload();
                        }


                    });



                });



            },
            eventSources: ARRAY



        });
        TEMP = $('#calendar').fullCalendar('getEventSources')

    }
    ///////sort by name//////////
    function compare(a, b) {
        if (a.summary.toLowerCase() < b.summary.toLowerCase())
            return -1;
        if (a.summary.toLowerCase() > b.summary.toLowerCase())
            return 1;
        return 0;
    }


    var ARRAY;
    var TEMP;

    function checkbox(ev) {
        console.log(ev)
        if (!$(this).is(':checked'))
            console.log("not")
        else console.log("check")
    }


    function setSigninStatus(isSignedIn) {

        user = GoogleAuth.currentUser.get();
        var isAuthorized = user.hasGrantedScopes(SCOPE);




        if (isAuthorized) {
//            if (user.w3.U3 == email_check){
                $('#ggez').attr('class', 'row');
                $('#insert').css('display', 'inline');
                $('#sign-in-or-out-button').css('display', 'none');
                $('#revoke-access-button').css('display', 'none');
                $('#GoBtn').css('display', 'inline');
                $('#auth-status').html('You are currently signed in and have granted ' +
                    'access to this app.');
                if(email_check == 'nawakorn.k@kkumail.com') {
                    $('#qwe').css('display', 'inline');
                }
                console.log(user);
                ARRAY = [];
                gapi.client.calendar.calendarList.list().then(function (resp) {
//                                console.log(resp)
                    EmailComp1 = user.w3.U3
//                                console.log(user.w3.U3)
                    var list = $("#list");
                    var select = $("#cal_select");
                    resp.result.items = resp.result.items.sort(compare);   //////resp.result.items[o].summary

                    for (o = 1; o < resp.result.items.length; o++) {
                        list.append('<div class="rcorners4" style="color: ' + resp.result.items[o].backgroundColor + '">' +
                            '<input  type="checkbox" value="' + (o - 1) + '" checked>' +
                            '<div style="cursor:pointer" id="please"  data-toggle="popover" ' +
                            'title="<button onclick=Delete(\'' + resp.result.items[o].id + '\') value=resp.result.items[o].id()>Remove</button>" ' +
                            'data-content="">' +
                            resp.result.items[o].summary + '</div>' + '<div>');
                        list.append('<br>');
                        select.append('<option value="' + resp.result.items[o].id + '">' + resp.result.items[o].summary + '</option>');
                        ARRAY.push({
                            summary: resp.result.items[o].summary,
                            backgroundColor: resp.result.items[o].backgroundColor,
                            googleCalendarId: resp.result.items[o].id,
                            className: ""
                        })
                    }
//                                console.log(ARRAY)


                    $('[data-toggle="popover"]').popover({html: true, button: true});


                    $("input:checkbox").click(function () {
                        var HAHAHA = $('#calendar').fullCalendar('getEventSources');
                        if ($(this).is(':checked')) {
                            HAHAHA[$(this).val()].className[0] = "";
                            $('#calendar').fullCalendar('addEventSource', HAHAHA);
                        } else {
                            HAHAHA[$(this).val()].className[0] = "hidden";
                        }
                        $('#calendar').fullCalendar('addEventSource', HAHAHA);
                        $('#calendar').fullCalendar('rerenderEvents');

                    });
                    calendar(ARRAY);

                })
//            }else{
//                revokeAccess().click();
//            }
        } else {
            $('#ggez').attr('class', 'row hidden')
            $('#sign-in-or-out-button').html('Connect To Calendar');
            $('#revoke-access-button').css('display', 'none');
            $('#GoBtn').css('display', 'none');
            $('#auth-status').html('You have not authorized this app or you are ' +
                'signed out.');

        }
    }
    function updateSigninStatus(isSignedIn) {

        setSigninStatus();
    }

</script>
</html>
