<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\Requirement;
use yii\widgets\ActiveForm;
use app\models\ProcessRequirement;
use app\models\Project;
use app\models\ProcessRequirementConnect;
use app\models\ProcessProgressFile;
use app\models\ProcessProgressConnect;


/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $model app\models\Requirement */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;
$project_id_k = "";
$process_id_k = "";
$type_k = "";
$bar_set = 0.00;
$bar_day =0.00;
$bar_month =0.00;
$bar_constant = 0.00;
$count = 1;
$check_requirement = 1;
$check_process_add = null;

$bar_sets = 0.00;
$bar_days =0.00;
$bar_months =0.00;
$bar_constants = 0.00;
$score_full_sum = 0;
$score_full = 0;
?>

<link href="<?= Yii::$app->homeUrl ?>assets/css/gantt.css" rel="stylesheet" type="text/css" />

<section id="middle" >
    <header id="page-header">
        <h1>กำหนดการโครงงาน</h1>
        <ol class="breadcrumb">
            <li><a href="<?php Yii::$app->homeUrl ?>../project/project_detail?project_id=<?= $project_id ?>&id=<?= $session['pfc_id'] ?>&type_degree=<?= $type_degree ?>">
                    <?= $project_name ?></a></li>
            <li class="active">กำหนดการโครงงาน <?= $project_name ?></li>
        </ol>

    </header>
    <div class="padding-20">
        <div class="row">
            <ul class="nav">

                <label><!-- PER PAGE SELECTOR . you can move it to panel-heading -->
                    <select class="form-control pointer" id="change-page-size">
                        <option value="1">1 / page</option>
                        <option value="5">5 / page</option>
                        <option value="10" selected="selected">10 / page</option>
                        <option value="100">All</option>
                    </select>
                </label><!-- /PER PAGE SELECTOR -->

                <table class="fooTableInit" width='100' style='table-layout:fixed'>
                    <thead>
                    <tr>
                        <th class="footable-visible footable-sortable" style="width: 250px">หัวข้อ</th>
                        <th class="footable-visible footable-sortable" style="width: 670px">
                            <div>
                                <?php
                                $month = ['ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.'];
                                for($i=0;$i<12;$i++){
                                ?>
                                <div class="stacked-bar-graph">
                                    <span style="width:60px" class="block-mount"><?= $month[$i]; ?></span>
                                    <?php } ?>
                                </div>
                                <?php for($i=0;$i<12;$i++){?>
                                <div class="stacked-bar-graph">
                                    <span style="width:15px" class="block-week">1</span>
                                    <span style="width:15px" class="block-week">2</span>
                                    <span style="width:15px" class="block-week">3</span>
                                    <span style="width:15px" class="block-week">4</span>
                                    <?php } ?>
                                </div>

                            </div>
                        </th>
                        <th class="footable-visible footable-sortable"style="width: 70px">คะแนน</th>
                        <th data-type="text" data-hide = "s600,s1000" class=""></th>
                    </tr>
                    </thead>

                    <tbody>

    <!-- ----------------------------------------------------------------------------------------------------------------- -->

    <?php $process_id_k = $process[0]->process_id; ?>
    <?php $project_id_k = $process[0]->project_id; ?>
    <?php $type_k = $type; ?>
    <?php foreach ($process_progress as $process_progressn){
        foreach ($process_add_con as $process_add_cons) {
            if ($process_add_cons->process_progress_id == $process_progressn->process_progress_id) {
                foreach ($process_add as $process_adds) {
                    if ($process_adds->process_add_id == $process_add_cons->process_add_id) {
                        $add_id = $process_adds->process_add_id;

//=================================================== Bar Calculate =============================================================================

                        $start_dates = strtotime($process_adds->process_add_date_start);
                        $end_dates = strtotime($process_adds->process_add_date_end);
                        $start_date_constants = strtotime($start_date_constant);
                        $bar_constant_ms = 0;
                        $bar_constant_ds = 0;

//============================================= White Bar Calculate =============================================================================

                        if ($start_date_constants != $start_dates) {
                            if (date('y', $start_date_constants) != date('y', $start_dates)) {
                                $bar_constant_ms = (12 - date('m', $start_date_constants) + date('m', $start_dates)) * 4;
                            } else {
                                $bar_constant_ms = (date('m', $start_dates) - date('m', $start_date_constants)) * 4;
                                if (date('m', $start_date_constants) != date('m', $start_dates)) {
                                    $bar_constant_ms = (date('m', $start_dates) - date('m', $start_date_constants)) * 4;
                                }
                            }

                            $bar_constant_ds = round((date('d', $start_dates) - date('d', $start_date_constants)) / 7);

                            $bar_constants = $bar_constant_ds + $bar_constant_ms;
                        } else {
                            $bar_constants = 0;
                        }


//===========================================  End White Bar Calculate ========================================================================

                        $bar_sets = $end_dates - $start_dates;
                        $bar_sets = round((floor($bar_sets / (60 * 60 * 24)) - 1) / 7);

//=================================================== End Bar Calculate =========================================================================
                        ?>
                        <tr>
                            <td><?= $process_progressn->process_progress_no ?>
                                .<?= $process_adds->process_add_topic ?></td>
                            <td>
                                <div class="stacked-bar-graph">

                                    <?php $iss = 1;
                                    while ($bar_constants >= $iss): ?>
                                        <span style="width:15px" class="bar-1"></span>
                                        <?php $iss++; endwhile; ?>

                                    <?php $jss = 1;
                                    while ($bar_sets >= $jss): ?>
                                        <span style="width:15px" class="bar-2"></span>
                                        <?php $jss++; endwhile; ?>

                                    <?php $kss = 1;
                                    while (48 - ($bar_constants + $bar_sets) >= $kss): ?>
                                        <span style="width:15px" class="bar-1"></span>
                                        <?php $kss++; endwhile; ?>
                                </div>

                            </td>

                            <!-- =========================================================    Chart    ================================================================= -->

                            <td style="text-align:center;">
                                <div>
                                    <?php if($process_progressn->process_progress_score != 0){ ?>
                                        <span class="easyPieChart" data-percent="<?= $process_progressn->process_progress_score/$process_progressn->process_progress_score_full*100 ?>"
                                              data-easing="easeOutBounce" data-barColor="#F08080"
                                              data-trackColor="#dddddd" data-scaleColor="#dddddd"
                                              data-size="43" data-lineWidth="4" onclick="clickScore(this)"
                                              onmouseover="scorePopup()">
                                        </span>
                                    <?php }else{ ?>
                                        <span class="easyPieChart" data-percent="0"
                                              data-easing="easeOutBounce" data-barColor="#F08080"
                                              data-trackColor="#dddddd" data-scaleColor="#dddddd"
                                              data-size="43" data-lineWidth="4" onclick="clickScore(this)"
                                              onmouseover="scorePopup()">
                                        </span>
                                    <?php } ?>
                                </div>

                                <div>
                                    <span>
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                                data-target="#bs-example-modal-lg-score-<?= $process_progressn->process_progress_id ?>">
                                            <?= $process_progressn->process_progress_score ?> / <?= $process_progressn->process_progress_score_full ?>
                                        </button>
                                    </span>
                                </div>
                            </td>

                            <!-- =========================================================    Chart    ================================================================= -->

                            <td style="display: none;">
                                <div>
                                    รายละเอียด : <?= $process_adds->process_add_detail ?><br>
                                    วันที่กำหนด : <?= date('d/m/Y', $start_dates) ?>
                                    - <?= date('d/m/Y', $end_dates) ?>
                                </div>
                                <br>

                                <!-- ========================================================= Requirement check ================================================================= -->
                                <?php $requirement_check = 0; ?>
                                <?php foreach ($process_requirement as $process_requirements_check) {
                                    if ($process_requirements_check->process_progress_id == $process_progressn->process_progress_id) {
                                        $requirement_check = 1;
                                    }
                                }
                                ?>

                                <!-- ========================================================= Requirement check ================================================================= -->

                                <?php if ($requirement_check == 1) { ?>
                                    <table class="table table-bordered nomargin">
                                        <thead>
                                        <tr class="warning">
                                            <th style="width: 150px">
                                                หัวข้อกำหนดการย่อย
                                            </th>
                                            <th style="width: 250px">รายละเอียด</th>
                                            <th style="width: 150px">ไฟล์งาน</th>
                                            <th style="width: 15px"></th>
                                            <th style="width: 150px">ตรวจสอบ</th>
                                        </tr>
                                        </thead>
                                        <?php foreach ($process_requirement as $process_requirements) {
                                            if ($process_requirements->process_progress_id == $process_progressn->process_progress_id) { ?>
                                                <tbody>
                                                <tr class="warning">
                                                    <td><?= $process_requirements->process_requirement_topic ?></td>
                                                    <td><?= $process_requirements->process_requirement_detail ?></td>
                                                    <td>
                                                        <div class="col-md-12 col-sm-12">
                                                            <label>อาจารย์</label>
                                                            <div class="col-md-12">
                                                                <select name="page" onChange="goTo(this.options[this.selectedIndex].value)" class="listBox" style="width: 250px">
                                                                    <option selected="selected">เลือกไฟล์...</option>
                                                                    <?php $process_requirement_con = ProcessRequirementConnect::find()->where("process_requirement_id like :b", [":b" => $process_requirements->process_requirement_id])->all();
                                                                    $process_progress_file = ProcessProgressFile::find()->all();
                                                                    foreach ($process_requirement_con as $process_requirement_cons){
                                                                        foreach ($process_progress_file as $process_progress_files){
                                                                            if($process_requirement_cons->process_progress_file_id == $process_progress_files->process_progress_file_id){
                                                                                if($process_progress_files->process_progress_file_persontype == 1){ ?>
                                                                                    <option style="width: 250px" value="<?= Yii::$app->homeUrl ?>process/process_download?fileupload=<?= $process_progress_files->process_progress_file_progress ?>&process_id=<?= $process_progressn->process_id ?>">
                                                                                                    <?= $process_progress_files->process_progress_file_name.
                                                                                    ' / '.$process_progress_files->process_progress_file_date ?></option>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12">
                                                            <label>นักศึกษา</label>
                                                            <div class="col-md-12">
                                                                <select name="page" onChange="goTo(this.options[this.selectedIndex].value)" class="listBox" style="width: 250px">
                                                                    <option selected="selected">เลือกไฟล์...</option>
                                                                    <?php $process_requirement_con = ProcessRequirementConnect::find()->where("process_requirement_id like :b", [":b" => $process_requirements->process_requirement_id])->all();
                                                                    $process_progress_file = ProcessProgressFile::find()->all();
                                                                    foreach ($process_requirement_con as $process_requirement_cons){
                                                                        foreach ($process_progress_file as $process_progress_files){
                                                                            if($process_requirement_cons->process_progress_file_id == $process_progress_files->process_progress_file_id){
                                                                                if($process_progress_files->process_progress_file_persontype == 2){ ?>
                                                                                    <option style="width: 250px" value="<?= Yii::$app->homeUrl ?>process/process_download?fileupload=<?= $process_progress_files->process_progress_file_progress ?>&process_id=<?= $process_progressn->process_id ?>">
                                                                                    <?= $process_progress_files->process_progress_file_name.
                                                                                        ' / '.$process_progress_files->process_progress_file_date ?></option>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td style="text-align:center;">
                                                        <button type="button"
                                                                class="btn btn-default btn-xs"
                                                                data-toggle="modal"
                                                                data-target="#bs-example-modal-lg-upload-<?= $process_requirements->process_requirement_id ?>"
                                                                style="width: 80px; height: 30px; margin-top: 10px">
                                                            <i class="fa fa-cloud-upload"></i>
                                                            Upload
                                                        </button>

                                                        <button type="button"
                                                                data-toggle="modal" class="btn btn-default btn-xs"
                                                                data-target="#bs-example-modal-lg-edit-sub-<?= $process_requirements->process_requirement_id ?>"
                                                                style="width: 80px; height: 30px; margin-top: 10px">
                                                            <i class="fa fa-file-text-o"></i>แก้ไข
                                                        </button>

                                                        <button type="button"
                                                                data-toggle="modal" class="btn btn-default btn-xs"
                                                                data-target="#bs-example-modal-lg-delete-sub-<?= $process_requirements->process_requirement_id ?>"
                                                                style="width: 80px; height: 30px; margin-top: 10px">
                                                            <i class="fa fa-times white"></i>ลบ
                                                        </button>

                                                    </td>

                                                    <td style="text-align:center;">
                                                        <?php if($process_requirements->process_requirement_status == 1){ ?>
                                                            <img src="<?= Yii::$app->homeUrl ?>assets/images/pfc_pass.png" alt width="70" style="margin-top: 30px">
                                                        <?php }else{ ?>
                                                            <img src="<?= Yii::$app->homeUrl ?>assets/images/pfc_wait.png" alt width="70">
                                                            <form action="<?= Yii::$app->homeUrl ?>process/process_re_pass" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                                                <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                                                <input type="hidden" name="process_pro_id" value="<?= $process_progressn->process_progress_id ?>" />
                                                                <input type="hidden" name="process_re_id" value="<?= $process_requirements->process_requirement_id ?>" />
                                                                <input type="hidden" name="type" value="<?= $type_k ?>" />
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <button type="submit" class="btn btn-blue">ยืนยันการตรวจสอบ</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        <?php } ?>
                                                    </td>

                                                </tr>
                                                </tbody>
                                            <?php } ?>
                                        <?php } ?>
                                    </table>
                                    <br>
                                    <div>
                                        <button type="button"
                                                class="btn btn-default btn-xs"
                                                data-toggle="modal"
                                                data-target="#bs-example-modal-lg-edit-<?= $process_progressn->process_progress_id ?>">
                                            <i class="fa fa-file-text-o"></i>
                                            แก้ไขรายละเอียดของกำหนดการ
                                        </button>

                                        <button type="button"
                                                class="btn btn-default btn-xs"
                                                data-toggle="modal"
                                                data-target="#bs-example-modal-lg-add-sub-<?= $process_progressn->process_progress_id ?>">
                                            <i class="fa fa-file-text-o"></i>
                                            เพิ่มกำหนดการกำหนดการย่อย
                                        </button>

                                        <button type="button"
                                                class="btn btn-default btn-xs"
                                                data-toggle="modal"
                                                data-target="#bs-example-modal-lg-<?= $process_progressn->process_progress_id ?>">
                                            <i class="fa fa-times white"></i>
                                            ลบกำหนดการ
                                        </button>

                                    </div>

                                <?php } elseif (isset($process_requirement)) { ?>

                                    <!-- ========================================================= Requirement ================================================================= -->

                                    <!-- ========================================================= Progress ================================================================= -->
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-1 col-sm-1">
                                                    <label>อาจารย์</label>
                                                    <div class="col-md-2">
                                                        <select name="page" onChange="goTo(this.options[this.selectedIndex].value)" class="listBox" style="width: 250px">
                                                            <option selected="selected" value="--" >เลือกไฟล์...</option>
                                                            <?php $process_progress_con = ProcessProgressConnect::find()->where("process_progress_id like :b", [":b" => $process_progressn->process_progress_id])->all();
                                                                  $process_progress_file = ProcessProgressFile::find()->all();
                                                                  foreach ($process_progress_con as $process_progress_cons){
                                                                     foreach ($process_progress_file as $process_progress_files){
                                                                       if($process_progress_cons->process_progress_file_id == $process_progress_files->process_progress_file_id){
                                                                           if($process_progress_files->process_progress_file_persontype == 1){?>
                                                                              <option value="<?= Yii::$app->homeUrl ?>process/process_download?fileupload=<?= $process_progress_files->process_progress_file_progress ?>&process_id=<?= $process_progressn->process_id ?>">
                                                                                  <?= $process_progress_files->process_progress_file_name.
                                                                                  ' / '.$process_progress_files->process_progress_file_date ?>
                                                                              </option>
                                                                           <?php } ?>
                                                                       <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-1 col-sm-1">
                                                    <label>นักศึกษา</label>
                                                    <div class="col-md-1">
                                                        <select name="page" onChange="goTo(this.options[this.selectedIndex].value)" class="listBox" style="width: 250px">
                                                            <option selected="selected">เลือกไฟล์...</option>
                                                            <?php $process_progress_con = ProcessProgressConnect::find()->where("process_progress_id like :b", [":b" => $process_progressn->process_progress_id])->all();
                                                            $process_progress_file = ProcessProgressFile::find()->all();
                                                            foreach ($process_progress_con as $process_progress_cons){
                                                                foreach ($process_progress_file as $process_progress_files){
                                                                    if($process_progress_cons->process_progress_file_id == $process_progress_files->process_progress_file_id){
                                                                        if($process_progress_files->process_progress_file_persontype == 2){?>
                                                                            <option value="<?= Yii::$app->homeUrl ?>process/process_download?fileupload=<?= $process_progress_files->process_progress_file_progress ?>&process_id=<?= $process_progressn->process_id ?>">
                                                                                <?= $process_progress_files->process_progress_file_name.
                                                                                ' / '.$process_progress_files->process_progress_file_date ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <?php if($process_progressn->process_progress_status_id == 1){ ?>
                                            <img src="<?= Yii::$app->homeUrl ?>assets/images/pfc_pass.png" alt width="150" style="margin-left: 400px">
                                        <?php }else{ ?>
                                            <img src="<?= Yii::$app->homeUrl ?>assets/images/pfc_wait.png" alt width="150" style="margin-left: 400px">
                                            <form action="<?= Yii::$app->homeUrl ?>process/process_pass" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                                <input type="hidden" name="process_pro_id" value="<?= $process_progressn->process_progress_id ?>" />
                                                <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                                <input type="hidden" name="type" value="<?= $type_k ?>" />
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-blue"
                                                                style="margin-left: 330px;
                                                                width: 300px; height: 50px;
                                                                font-size: 17px">
                                                            ยืนยันการตรวจสอบ</button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php } ?>
                                    </div>

                                    <div class="col-md-12" style="margin-top: 20px">
                                        <button type="button" class="btn btn-default btn-xs"
                                                data-toggle="modal"
                                                data-target="#bs-example-modal-lg-edit-<?= $process_progressn->process_progress_id ?>">
                                            <i class="fa fa-file-text-o"></i>
                                            แก้ไขรายละเอียดของกำหนดการ
                                        </button>

                                        <button type="button"
                                                class="btn btn-default btn-xs"
                                                data-toggle="modal"
                                                data-target="#bs-example-modal-lg-add-sub-<?= $process_progressn->process_progress_id ?>">
                                            <i class="fa fa-file-text-o"></i>
                                            เพิ่มกำหนดการกำหนดการย่อย
                                        </button>

                                        <button type="button" class="btn btn-default btn-xs"
                                                data-toggle="modal"
                                                data-target="#bs-example-modal-lg-upload-<?= $process_progressn->process_progress_id ?>">
                                            <i class="fa fa-cloud-upload"></i> Upload
                                        </button>

                                        <button type="button"
                                                class="btn btn-default btn-xs"
                                                data-toggle="modal"
                                                data-target="#bs-example-modal-lg-delete-<?= $process_progressn->process_progress_id ?>">
                                            <i class="fa fa-times white"></i>
                                            ลบกำหนดการ
                                        </button>
                                    </div>

                                <?php } ?>

                                <!-- ========================================================= Progress ================================================================= -->

                            </td>
                        </tr>
                    <?php $score_full_sum = $score_full_sum + $process_progressn->process_progress_score_full;
                        $score_full = $score_full + $process_progressn->process_progress_score;
                    }
                }
            }
        }
    } ?>
        <!-- ------------------------------------------------------------------------------------------------------------------ -->

                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">ผลรวมคะแนน</td>
                            <td style="text-align:center;"><?= $score_full ?>/<?= $score_full_sum ?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="margin-top20 pagination text-center"><!-- PAGINATION --></div>
            </ul>

            <!-- ------------------------------------------------------------------------------------------------------------------ -->

            <div class="padding-3">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bs-example-modal-lg"><i class="et-clipboard">
                    </i> เพิ่มกำหนดการ</button>

                <a target ="_blank" href="https://pdf.wondershare.com/pdfelement/" class="btn btn-danger">
                    <i class="et-clipboard">
                    </i> PDFelement 6
                </a>
            </div>



            <!-- ////////////////////////////////////////////////////// ADD /////////////////////////////////////////////////////// -->
            <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- header modal -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myLargeModalLabel">เพิ่มกำหนดการ</h4>
                        </div>
                        <!-- body modal -->
                        <div class="modal-body">
                            <form action="<?= Yii::$app->homeUrl ?>process/process_add" method="post" enctype="multipart/form-data">
                                <fieldset>
                                    <!-- required [php action request] -->
                                    <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                    <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                    <input type="hidden" name="type" value="<?= $type_k ?>" />

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>ลำดับกำหนดการ</label>
                                                <input type="number" name="process_no_form" id="process_no_form" value="" min="1" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>หัวข้อกำหนดการ</label>
                                                <input type="text" name="process_topic_form" id="process_topic_form" value="" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>รายละเอียดกำหนดการ</label>
                                                <textarea name="process_detail_form" id="process_detail_form" rows="4" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6">
                                                <label>วันเริ่มต้น</label>
                                                <input type="text" name="process_date_start_form" id="process_date_start_form" value="" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false" required>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label>วันสุดท้าย</label>
                                                <input type="text" name="process_date_end_form" id="process_date_end_form" value="" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false" required>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- ------ foot -------- -->
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" href="<?= Yii::$app->homeUrl ?>process/process_add" class="btn btn-green">เพิ่มกำหนดการ</button>
                                        </div>
                                    </div>

                                    <!-- ------ foot -------- -->

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ////////////////////////////////////////////////////// ADD /////////////////////////////////////////////////////// -->


            <!-- /////////////////////////////////////////////////// Edit process //////////////////////////////////////////////////// -->
            <?php foreach ($process_progress as $process_progressn3){
                foreach ($process_add_con as $process_add_cons3) {
                    if ($process_add_cons3->process_progress_id == $process_progressn3->process_progress_id) {
                        foreach ($process_add as $process_adds3) {
                            if ($process_adds3->process_add_id == $process_add_cons3->process_add_id) { ?>
                                <div class="modal fade" id="bs-example-modal-lg-edit-<?= $process_progressn3->process_progress_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- header modal -->
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myLargeModalLabel">แก้ไขรายละเอียดกำหนดการ</h4>
                                            </div>
                                            <!-- body modal -->
                                            <div class="modal-body">
                                                <form action="<?= Yii::$app->homeUrl ?>process/process_edit" method="post" enctype="multipart/form-data">
                                                    <fieldset>
                                                        <!-- required [php action request] -->
                                                        <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                                        <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                                        <input type="hidden" name="type" value="<?= $type_k ?>" />
                                                        <input type="hidden" name="process_progress_id" value="<?= $process_progressn3->process_progress_id ?>" />
                                                        <input type="hidden" name="process_add_id" value="<?= $process_add_cons3->process_add_id ?>" />

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <label>ลำดับกำหนดการ</label>
                                                                    <input type="number" name="edit_no_form" id="edit_no_form" value="<?= $process_progressn3->process_progress_no ?>" class="form-control" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <label>หัวข้อกำหนดการ</label>
                                                                    <input type="text" name="edit_topic_form" id="edit_topic_form" value="<?= $process_adds3->process_add_topic ?>" class="form-control" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <label>รายละเอียดของกำหนดการ</label>
                                                                    <textarea name="edit_detail_form" id="edit_detail_form" rows="4" class="form-control" required><?= $process_adds3->process_add_detail ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <label>วันที่เริ่มต้น</label>
                                                                    <input type="text" name="edit_date_start_form" id="edit_date_start_form" value="<?= $process_adds3->process_add_date_start ?>" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false" required>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <label>วันสุดท้าย</label>
                                                                    <input type="text" name="edit_date_end_form" id="edit_date_end_form" value="<?= $process_adds3->process_add_date_end ?>" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </fieldset>

                                                    <!-- ------ foot -------- -->
                                                    <div class="row"
                                                         style="margin-top: 20px;">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                                            <button type="submit" href="<?= Yii::$app->homeUrl ?>process/process_edit" class="btn btn-green">บันทึก</button>
                                                        </div>
                                                    </div>

                                                    <!-- ------ foot -------- -->

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                }
            } ?>
            <!-- /////////////////////////////////////////////////// Edit process //////////////////////////////////////////////////// -->


            <!-- ////////////////////////////////////////////////////// ADD sub /////////////////////////////////////////////////////// -->
            <?php foreach ($process_progress as $process_progressn3){ ?>
                <div class="modal fade" id="bs-example-modal-lg-add-sub-<?= $process_progressn3->process_progress_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">เพิ่มกำหนดการ</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form action="<?= Yii::$app->homeUrl ?>process/process_add_sub" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <!-- required [php action request] -->
                                        <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                        <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                        <input type="hidden" name="type" value="<?= $type_k ?>" />
                                        <input type="hidden" name="process_progress_id" value="<?= $process_progressn3->process_progress_id ?>" />

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <label>หัวข้อกำหนดการ</label>
                                                    <input type="text" name="process_topic_form_sub" id="process_topic_form_sub" value="" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <label>รายละเอียดกำหนดการ</label>
                                                    <textarea name="process_detail_form_sub" id="process_detail_form_sub" rows="4" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- ------ foot -------- -->
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" href="<?= Yii::$app->homeUrl ?>process/process_add_sub" class="btn btn-green">เพิ่มกำหนดการ</button>
                                            </div>
                                        </div>

                                        <!-- ------ foot -------- -->

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- ////////////////////////////////////////////////////// ADD sub /////////////////////////////////////////////////////// -->



            <!-- /////////////////////////////////////////////////////// Score /////////////////////////////////////////////////////// -->
            <?php foreach ($process_progress as $process_progressn3){ ?>
                <div class="modal fade" id="bs-example-modal-lg-score-<?= $process_progressn3->process_progress_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">แก้ไขคะแนนกำหนดการ</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form action="<?= Yii::$app->homeUrl ?>process/process_score" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <!-- required [php action request] -->
                                        <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                        <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                        <input type="hidden" name="type" value="<?= $type_k ?>" />
                                        <input type="hidden" name="process_progress_id" value="<?= $process_progressn3->process_progress_id ?>" />

                                        <div>
                                            <div class="table-responsive nomargin">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th><i class="pull-right hidden-xs" style="width: 720px"></i>กำหนดการ</th>
                                                        <th><i class="pull-right hidden-xs" style="width: 80px"></i>คะแนนที่กำหนด</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php foreach ($process_progress as $process_progressn2){
                                                        foreach ($process_add_con as $process_add_cons) {
                                                            if ($process_add_cons->process_progress_id == $process_progressn2->process_progress_id) {
                                                                foreach ($process_add as $process_adds2) {
                                                                    if ($process_adds2->process_add_id == $process_add_cons->process_add_id) {
                                                                        $add_id = $process_adds2->process_add_id; ?>
                                                                        <?php if($process_progressn3->process_progress_id == $process_progressn2->process_progress_id){ ?>
                                                                        <tr class="danger">
                                                                        <?php }else{ ?>
                                                                        <tr>
                                                                        <?php } ?>
                                                                            <td><?= $process_adds2->process_add_topic ?></td>
                                                                            <td style="text-align: center"><?= $process_progressn2->process_progress_score_full ?></td>
                                                                        </tr>
                                                                    <?php }
                                                                }
                                                            }
                                                        }
                                                    } ?>
                                                    <tr class="info">
                                                        <td style="text-align: center">
                                                            คะแนนเต็มของโครงงาน :  <?= $score_full_sum ?> คะแนน<br>
                                                            คะแนนเหลืออีก :  <?= 100-$score_full_sum ?> คะแนน ที่ต้องกำหนด
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3">
                                            <label>คะแนนที่ให้</label>
                                            <input type="number" name="score" id="score" min="0" max="<?= $process_progressn3->process_progress_score_full ?>" value="<?= $process_progressn3->process_progress_score ?>" class="form-control">
                                        </div>

                                        <div class="col-md-3 col-sm-3">
                                            <label>คะแนนเต็ม</label>
                                            <input type="number" name="score_full" id="score_full" min="1" max="100" value="<?= $process_progressn3->process_progress_score_full ?>" class="form-control" required>
                                        </div>

                                    </fieldset>

                                    <!-- ------ foot -------- -->
                                    <div class="row"
                                         style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" href="<?= Yii::$app->homeUrl ?>process/process_score" class="btn btn-primary">บันทึก</button>
                                        </div>
                                    </div>

                                    <!-- ------ foot -------- -->

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- /////////////////////////////////////////////////////// Score /////////////////////////////////////////////////////// -->



            <!-- ////////////////////////////////////////////////////// Upload progress /////////////////////////////////////////////////////// -->
            <?php foreach ($process_progress as $process_progressn3){ ?>
            <div class="modal fade" id="bs-example-modal-lg-upload-<?= $process_progressn3->process_progress_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- header modal -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myLargeModalLabel">Upload</h4>
                        </div>
                        <!-- body modal -->
                        <div class="modal-body">
                            <form method=post action="<?= Yii::$app->homeUrl ?>process/process_upload" enctype="multipart/form-data">
                                <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                <input type="hidden" name="type" value="<?= $type_k ?>" />
                                <input type="hidden" name="process_progress_id" value="<?= $process_progressn3->process_progress_id ?>" />
                                <input type="hidden" name="upload_check" value="1" />

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label>เฉพาะไฟล์ docx , PDF , Zip เท่านั้น</label>
                                            <div class="fancy-file-upload fancy-file-default">
                                                <i class="fa fa-upload"></i>
                                                <input type="file" class="form-control" name="upload" onchange="jQuery(this).next('input').val(this.value);" />
                                                <input type="text" class="form-control" placeholder="no file selected" readonly="" />
                                                <span class="button">Choose File</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row"
                                     style="margin-top: 20px;">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" href="" class="btn btn-primary">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- ////////////////////////////////////////////////////// Upload progress /////////////////////////////////////////////////////// -->


            <!-- ////////////////////////////////////////////////////// Upload Requirement /////////////////////////////////////////////////////// -->
            <?php foreach ($process_requirement as $process_requirementn1){ ?>
                <div class="modal fade" id="bs-example-modal-lg-upload-<?= $process_requirementn1->process_requirement_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">Upload</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form method=post action="<?= Yii::$app->homeUrl ?>process/process_upload" enctype="multipart/form-data">
                                    <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                    <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                    <input type="hidden" name="type" value="<?= $type_k ?>" />
                                    <input type="hidden" name="process_requirement_id" value="<?= $process_requirementn1->process_requirement_id ?>" />
                                    <input type="hidden" name="upload_check" value="2" />

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>เฉพาะไฟล์ docx , PDF , Zip เท่านั้น</label>
                                                <div class="fancy-file-upload fancy-file-default">
                                                    <i class="fa fa-upload"></i>
                                                    <input type="file" class="form-control" name="upload" onchange="jQuery(this).next('input').val(this.value);" />
                                                    <input type="text" class="form-control" placeholder="no file selected" readonly="" />
                                                    <span class="button">Choose File</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"
                                         style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" href="" class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- ////////////////////////////////////////////////////// Upload Requirement /////////////////////////////////////////////////////// -->




            <!-- ////////////////////////////////////////////////////// Delete /////////////////////////////////////////////////////// -->
            <?php foreach ($process_progress as $process_progressn3){
                foreach ($process_add_con as $process_add_cons3) {
                    if ($process_add_cons3->process_progress_id == $process_progressn3->process_progress_id) {
                        foreach ($process_add as $process_adds3) {
                            if ($process_adds3->process_add_id == $process_add_cons3->process_add_id) { ?>
                                <div class="modal fade" id="bs-example-modal-lg-delete-<?= $process_progressn3->process_progress_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- header modal -->
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myLargeModalLabel">ยืนยันการลบกำหนดการ</h4>
                                            </div>
                                            <!-- body modal -->
                                            <div class="modal-body">
                                                <form action="<?= Yii::$app->homeUrl ?>process/process_delete" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                                    <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                                    <input type="hidden" name="type" value="<?= $type_k ?>" />
                                                    <input type="hidden" name="delete_progress_id" value="<?= $process_progressn3->process_progress_id ?>" />
                                                    <input type="hidden" name="delete_add_id" value="<?= $process_add_cons3->process_add_id ?>" />
                                                    <input type="hidden" name="delete_add_con_id" value="<?= $process_add_cons3->process_add_connect_id ?>" />

                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-md-12 col-sm-12">
                                                                <label>ยืนยันการลบกำหนดการ </label>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row"
                                                         style="margin-top: 20px;">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                                            <button type="submit" href="<?= Yii::$app->homeUrl ?>process/process_delete" class="btn btn-danger">ยืนยัน</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                }
            } ?>
            <!-- ////////////////////////////////////////////////////// Delete /////////////////////////////////////////////////////// -->


            <!-- ////////////////////////////////////////////////////// Delete sub /////////////////////////////////////////////////////// -->
            <?php foreach ($process_requirement as $process_requirement3){ ?>
                <div class="modal fade" id="bs-example-modal-lg-delete-sub-<?= $process_requirement3->process_requirement_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">ยืนยันการลบกำหนดการ</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form action="<?= Yii::$app->homeUrl ?>process/process_delete_sub" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                    <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                    <input type="hidden" name="type" value="<?= $type_k ?>" />
                                    <input type="hidden" name="delete_sub_id" value="<?= $process_requirement3->process_requirement_id ?>" />

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>ยืนยันการลบกำหนดการ </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row"
                                         style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" href="<?= Yii::$app->homeUrl ?>process/process_delete_sub" class="btn btn-danger">ยืนยัน</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- ////////////////////////////////////////////////////// Delete sub /////////////////////////////////////////////////////// -->


            <!-- /////////////////////////////////////////////////// Edit process sub //////////////////////////////////////////////////// -->
            <?php foreach ($process_requirement as $process_requirement3){ ?>
                <div class="modal fade" id="bs-example-modal-lg-edit-sub-<?= $process_requirement3->process_requirement_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">แก้ไขรายละเอียดกำหนดการ</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form action="<?= Yii::$app->homeUrl ?>process/process_edit_sub" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <!-- required [php action request] -->
                                        <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                        <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                        <input type="hidden" name="type" value="<?= $type_k ?>" />
                                        <input type="hidden" name="edit_sub_id" value="<?= $process_requirement3->process_requirement_id ?>" />

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <label>หัวข้อกำหนดการ</label>
                                                    <input type="text" name="edit_topic_form" id="edit_topic_form" value="<?= $process_requirement3->process_requirement_topic ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <label>รายละเอียดของกำหนดการ</label>
                                                    <textarea name="edit_detail_form" id="edit_detail_form" rows="4" class="form-control"><?= $process_requirement3->process_requirement_detail ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>

                                    <!-- ------ foot -------- -->
                                    <div class="row"
                                         style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" href="<?= Yii::$app->homeUrl ?>process/process_edit_sub" class="btn btn-green">บันทึก</button>
                                        </div>
                                    </div>

                                    <!-- ------ foot -------- -->

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- /////////////////////////////////////////////////// Edit process sub //////////////////////////////////////////////////// -->



            <!-- /////////////////////////////////////////////////// js dropdown //////////////////////////////////////////////////// -->
            <script>
                function goTo (page) {
                    if (page != "" ) {
                        if (page == "--" ) {
                            resetMenu();
                        } else {
                            document.location.href = page;
                        }
                    }
                    return false;
                }
            </script>
            <!-- /////////////////////////////////////////////////// js dropdown //////////////////////////////////////////////////// -->

