<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ProcessProgress;
use app\models\PersonnelFile;
$session = Yii::$app->session;
$session->remove('sesValue');

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */

Yii::$app->view->params['title'] = 'Project List';

$count = 1;
$check_process_add = null;
?>


<section id="middle">
    <?php foreach ($project as $value): ?>
    <header id="page-header">
        <h1>รายละเอียดของโครงงาน</h1>
    </header>

    <div class="padding-20">
        <div id="panel-1" class="panel panel-default">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong class="size-1"><?= $value->project_name_th ?></strong>
                    <small class="size-12 weight-300 text-mutted hidden-xs"><?= $value->project_name_en ?></small>
                </span>
            </div>

            <div class="panel-body">
                <ul class="easypiecharts list-unstyled">
                    <div id="panel-misc-portlet-l2" class="panel panel-default">

                        <ul class="nav nav-tabs nav-justified">
                            <li class="active">
                                <a href="#jtab1_nobg" data-toggle="tab">
                                    <i class="glyphicon glyphicon-th-list"></i> ความคืบหน้าของโครงงาน
                                </a>
                            </li>
                            <li class="">
                                <a href="#jtab2_nobg" data-toggle="tab">
                                    <i class="fa fa-bar-chart"></i> คะแนนของโครงงาน
                                </a>
                            </li>
                        </ul>


                        <div class="panel-body">
                            <div class="tab-content transparent">

                                <div id="jtab1_nobg" class="tab-pane active">
                                    <li class="clearfix">
                                        <span class="easyPieChart" data-percent="<?= $check_progress_sum ?>" data-easing="easeOutBounce"
                                              data-barColor="#F86C6B" data-trackColor="#dddddd" data-scaleColor="#A9A9A9"
                                              data-size="300" data-lineWidth="50"
                                              style="margin-top: 15% ;margin-left: 15%">
                                            <span class="percent" style="font-size: 17px;"></span>
                                        </span>
                                    </li>
                                </div>

                                <div id="jtab2_nobg" class="tab-pane">
                                    <li class="clearfix">
                                        <span class="easyPieChart" data-percent="<?= $check_score_sum ?>" data-easing="easeOutBounce"
                                              data-barColor="#228B22" data-trackColor="#dddddd" data-scaleColor="#A9A9A9"
                                              data-size="300" data-lineWidth="50"
                                              style="margin-top: 15% ;margin-left: 15%">
                                            <span style="width:100%; top:50%;
                                                    position:absolute;
                                                    margin-top:-10px;
                                                    display: block;
                                                    text-align:center;
                                                    z-index: 5;
                                                    font-size: 17px"><?= $check_score_sum ?> / <?= $check_score_full ?>  คะแนน</span>
                                        </span>
                                    </li>
                                </div>

                            </div>
                        </div>
                    </div>

                    <li class="clearfix">
                        <div class="table-responsive">
                            <table class="table table-hover nomargin">
                                <thead>
                                    <tr>
                                        <th>กำหนดการ</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach ($process_progress as $process_progressn){
                                    foreach ($process_add_con as $process_add_cons) {
                                        if ($process_add_cons->process_progress_id == $process_progressn->process_progress_id
                                            and $process_add_cons->process_progress_id != $check_process_add) {
                                            $check_process_add = $process_add_cons->process_progress_id;
                                            foreach ($process_add as $process_adds) {
                                                if ($process_adds->process_add_id == $process_add_cons->process_add_id) {

                                                    $date_now = explode("-", date("Y-m-d"));
                                                    $date_end = explode("-", $process_adds->process_add_date_end);
                                                    $timStmp_now = mktime(0,0,0,$date_now[1],$date_now[2],$date_now[0]);
                                                    $timStmp_end = mktime(0,0,0,$date_end[1],$date_end[2],$date_end[0]);

                                                    if ($timStmp_now > $timStmp_end AND $process_progressn->process_progress_score == 0 ){
                                                        $process_progress_c = ProcessProgress::findOne($process_progressn->process_progress_id);
                                                        $process_progress_c->process_progress_status_id = 3;
                                                        $process_progress_c->update();
                                                    }elseif ($process_progressn->process_progress_score == 0 AND $timStmp_now < $timStmp_end) {
                                                        $process_progress_c = ProcessProgress::findOne($process_progressn->process_progress_id);
                                                        $process_progress_c->process_progress_status_id = 2;
                                                        $process_progress_c->update();
                                                    }else{
                                                        $process_progress_c = ProcessProgress::findOne($process_progressn->process_progress_id);
                                                        $process_progress_c->process_progress_status_id = 1;
                                                        $process_progress_c->update();
                                                    }

                                                    ?>
                                                    <tr>
                                                        <td><?=  $process_adds->process_add_topic ?></td>
                                                        <td>
                                                            <?php if($process_progressn->process_progress_status_id == 1){ ?>
                                                            <span class="label label-success">เสร็จสิ้น<span>
                                                            <?php }elseif ($process_progressn->process_progress_status_id == 2){ ?>
                                                            <span class="label label-info">ดำเนินการ<span>
                                                            <?php }elseif($process_progressn->process_progress_status_id == 3){ ?>
                                                            <span class="label label-danger">เกินระยะเวลา<span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </li>

                </ul>
            </div>
        </div>

        <!-------------------------------------------------------- Button ------------------------------------------------------------------>

        <div class="row">
        <!-------------------------------------------------------- BOX ------------------------------------------------------------------>
            <div class="col-md-3 col-sm-6">
                <div class="box info">
                    <div class="box-title">
                        <h4>Chat</h4>
                        <small class="block">พูดคุยปรึกษากับอาจารย์ที่ปรึกษา</small>
                        <i class="fa fa-comments"></i>
                    </div>

                    <a href="<?= Yii::$app->homeUrl ?>chat/chat?project_id=<?= $value->project_id ?>"
                       class="btn btn-featured btn-blue">
                        <span>CHAT</span>
                        <i class="et-chat"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="box warning">
                    <div class="box-title">
                        <h4>Process Gantt Chart</h4>
                        <small class="block">กำหนดการของโครงงาน</small>
                        <i class="fa fa-bar-chart-o"></i>
                    </div>

                    <a href="<?= Yii::$app->homeUrl ?>process/process?project_id=<?= $value->project_id ?>&type=2&id=<?= $session['pfc_id'] ?>&type_degree=<?= $type_degree ?>&process_gantt_type_code=<?= $process_gantt_type_code ?>"
                       class="btn btn-featured btn-warning">
                        <span>GANTT CHART</span>
                        <i class="et-bargraph"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="box success">
                    <div class="box-title">
                        <h4>Calendar</h4>
                        <small class="block">ปฎิทินการนัดหมาย</small>
                        <i class="fa fa fa-calendar"></i>
                    </div>

                    <a href="<?= Yii::$app->homeUrl ?>calendar/calendar"
                       class="btn btn-featured btn-success">
                        <span>CALENDAR</span>
                        <i class="et-calendar"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="box danger">
                    <div class="box-title">
                        <h4>Appointment Report</h4>
                        <small class="block">แบบฟอร์มการเข้าพบอาจารย์ที่ปรึกษา</small>
                        <i class="fa fa et-presentation"></i>
                    </div>

                    <?php $personnel_file = PersonnelFile::find()->all(); ?>
                    <?php if($personnel_file != null){ ?>
                        <a href="<?= Yii::$app->homeUrl ?>personnel/personnel_download?fileupload=<?= $personnel_file[0]->personnel_file_pro ?>"
                           class="btn btn-featured btn-red">
                            <span>Download</span>
                            <i class="glyphicon glyphicon-indent-right"></i>
                    <?php }else{ ?>
                        <a href=""
                           class="btn btn-featured btn-red">
                            <span>ไม่มีแบบฟอร์ม</span>
                            <i class="glyphicon glyphicon-indent-right"></i>
                    <?php } ?>
                    </a>
                </div>
            </div>


        <!-------------------------------------------------------- BOX ------------------------------------------------------------------>

        </div>
        <!-------------------------------------------------------- Button ------------------------------------------------------------------>
       <?php endforeach; ?>
    </div>
</section>




