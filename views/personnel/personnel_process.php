<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\ProcessProgress;
use yii\widgets\ActiveForm;

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
?>

<link href="<?= Yii::$app->homeUrl ?>assets/css/gantt.css" rel="stylesheet" type="text/css" />

<section id="middle" >
    <header id="page-header">
        <h1>กำหนดการของโครงงาน</h1>
        <ol class="breadcrumb">
            <li class="active">หน้าหลัก</li>
            <li><a href="javascript:history.back(1)">เลือกวิชาที่ต้องการ</a></li>
            <li class="active">กำหนดการของโครงงาน</li>
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
                        <option value="100" >All</option>
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
                    <?php $type_k = $type_degree; ?>
                    <?php foreach ($process_gantt as $process_gantts) {

//=================================================== Bar Calculate =============================================================================

                                        $start_dates = strtotime($process_gantts->process_gantt_date_start);
                                        $end_dates = strtotime($process_gantts->process_gantt_date_end);
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
                                            <td><?= $process_gantts->process_gantt_no ?>
                                                .<?= $process_gantts->process_gantt_topic ?></td>
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
                                                <?php if($process_gantts->process_gantt_score == 0){ ?>
                                                    <span>
                                                        <button type="button" class="btn btn-red btn-xs" data-toggle="modal"
                                                                data-target="#bs-example-modal-lg-score-<?= $process_gantts->process_gantt_id ?>"
                                                                style="width: 50px">
                                                            <?= $process_gantts->process_gantt_score ?>
                                                        </button>
                                                    </span>
                                                <?php }else{ ?>
                                                    <span>
                                                        <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                                                data-target="#bs-example-modal-lg-score-<?= $process_gantts->process_gantt_id ?>"
                                                                style="width: 50px">
                                                            <?= $process_gantts->process_gantt_score ?>
                                                        </button>
                                                    </span>
                                                <?php } ?>
                                            </td>

                                            <!-- =========================================================    Chart    ================================================================= -->

                                            <td style="display: none;">
                                                <div>
                                                    รายละเอียด : <?= $process_gantts->process_gantt_detail ?><br>
                                                    วันที่กำหนด : <?= date('d/m/Y', $start_dates) ?>
                                                    - <?= date('d/m/Y', $end_dates) ?>
                                                </div>
                                                <br>

                                                <div>
                                                    <button type="button" class="btn btn-default btn-xs"
                                                            data-toggle="modal"
                                                            data-target="#bs-example-modal-lg-edit-<?= $process_gantts->process_gantt_id ?>">
                                                        <i class="fa fa-file-text-o"></i>
                                                        แก้ไขรายละเอียดของกำหนดการ
                                                    </button>

                                                    <button type="button"
                                                            class="btn btn-default btn-xs"
                                                            data-toggle="modal"
                                                            data-target="#bs-example-modal-lg-delete-<?= $process_gantts->process_gantt_id ?>">
                                                        <i class="fa fa-file-text-o"></i>
                                                        ลบกำหนดการ
                                                    </button>
                                                </div>

                                            </td>

                                        </tr>
                                    <?php
                            $score_full_sum = $score_full_sum + $process_gantts->process_gantt_score;
                    } ?>
                    <!-- ------------------------------------------------------------------------------------------------------------------ -->

                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">ผลรวมคะแนน</td>
                            <td style="text-align:center;"><?= $score_full_sum ?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="margin-top20 pagination text-center"><!-- PAGINATION --></div>
            </ul>

            <!-- ------------------------------------------------------------------------------------------------------------------ -->

            <div class="padding-3">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bs-example-modal-lg"><i class="et-clipboard">
                    </i> เพิ่มกำหนดการ</button>

            </div>
            <!-- ------------------------------------------------------------------------------------------------------------------ -->

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
                            <form action="<?= Yii::$app->homeUrl ?>personnel/personnel_process_add" method="post" enctype="multipart/form-data">
                                <fieldset>
                                    <!-- required [php action request] -->
                                    <input type="hidden" name="type_degree" value="<?= $type_k ?>" />
                                    <input type="hidden" name="process_gantt_type_id" value="<?= $process_gantt_type_id ?>" />
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
                                            <button type="submit" class="btn btn-green">เพิ่มกำหนดการ</button>
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
            <?php foreach ($process_gantt as $process_gantts3) { ?>
                <div class="modal fade" id="bs-example-modal-lg-edit-<?= $process_gantts3->process_gantt_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">แก้ไขรายละเอียดกำหนดการ</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form action="<?= Yii::$app->homeUrl ?>personnel/personnel_process_edit" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <!-- required [php action request] -->
                                        <input type="hidden" name="process_gantt_type_id" value="<?= $process_gantt_type_id ?>" />
                                        <input type="hidden" name="type_degree" value="<?= $type_k ?>" />
                                        <input type="hidden" name="process_gantt_id" value="<?= $process_gantts3->process_gantt_id ?>" />

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <label>ลำดับกำหนดการ</label>
                                                    <input type="number" name="edit_no_form" id="edit_no_form" min="1" value="<?= $process_gantts3->process_gantt_no ?>" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <label>หัวข้อกำหนดการ</label>
                                                    <input type="text" name="edit_topic_form" id="edit_topic_form" value="<?= $process_gantts3->process_gantt_topic ?>" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <label>รายละเอียดของกำหนดการ</label>
                                                    <textarea name="edit_detail_form" id="edit_detail_form" rows="4" class="form-control" required><?= $process_gantts3->process_gantt_detail ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6">
                                                    <label>วันที่เริ่มต้น</label>
                                                    <input type="text" name="edit_date_start_form" id="edit_date_start_form" value="<?= $process_gantts3->process_gantt_date_start ?>" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false" required>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <label>วันสุดท้าย</label>
                                                    <input type="text" name="edit_date_end_form" id="edit_date_end_form" value="<?= $process_gantts3->process_gantt_date_end ?>" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false" required>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>

                                    <!-- ------ foot -------- -->
                                    <div class="row"
                                         style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" class="btn btn-green">บันทึก</button>
                                        </div>
                                    </div>

                                    <!-- ------ foot -------- -->

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- /////////////////////////////////////////////////// Edit process //////////////////////////////////////////////////// -->


            <!-- ////////////////////////////////////////////////////// Delete /////////////////////////////////////////////////////// -->
            <?php foreach ($process_gantt as $process_gantts3) {?>
                <div class="modal fade" id="bs-example-modal-lg-delete-<?= $process_gantts3->process_gantt_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">ยืนยันการลบกำหนดการ</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form action="<?= Yii::$app->homeUrl ?>personnel/personnel_process_delete" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="type_degree" value="<?= $type_k ?>" />
                                    <input type="hidden" name="delete_process_id" value="<?= $process_gantts3->process_gantt_id ?>" />
                                    <input type="hidden" name="process_gantt_type_id" value="<?= $process_gantt_type_id ?>" />

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
                                            <button type="submit"  class="btn btn-danger">ยืนยัน</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- ////////////////////////////////////////////////////// Delete /////////////////////////////////////////////////////// -->


            <!-- /////////////////////////////////////////////////////// Score /////////////////////////////////////////////////////// -->
            <?php foreach ($process_gantt as $process_gantts3){ ?>
                <div class="modal fade" id="bs-example-modal-lg-score-<?= $process_gantts3->process_gantt_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">แก้ไขคะแนนกำหนดการ</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form action="<?= Yii::$app->homeUrl ?>personnel/personnel_process_score" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <!-- required [php action request] -->

                                        <input type="hidden" name="type_degree" value="<?= $type_k ?>" />
                                        <input type="hidden" name="process_gantt_id" value="<?= $process_gantts3->process_gantt_id ?>" />
                                        <input type="hidden" name="process_gantt_type_id" value="<?= $process_gantt_type_id ?>" />

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
                                                    <?php foreach ($process_gantt as $process_gantts2) { ?>
                                                        <?php if($process_gantts2->process_gantt_id == $process_gantts3->process_gantt_id){ ?>
                                                            <tr class="danger">
                                                        <?php }else{ ?>
                                                            <tr>
                                                        <?php } ?>
                                                        <td><?= $process_gantts2->process_gantt_topic ?></td>
                                                        <td style="text-align: center"><?= $process_gantts2->process_gantt_score ?></td>
                                                        </tr>
                                                    <?php } ?>
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
                                            <label>คะแนนที่กำหนด</label>
                                            <input type="number" name="score_full" id="score_full" min="0" max="100" value="<?= $process_gantts3->process_gantt_score ?>" class="form-control">
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