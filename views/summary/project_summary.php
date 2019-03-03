<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ProcessGrantt;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */

Yii::$app->view->params['title'] = 'Project List';
$session = Yii::$app->session;
$score = 0;
$score_full = 0;
$count = 1;
?>

<section id="middle">
    <header id="page-header">
        <h1>สรุปผลโครงงาน</h1>
        <ol class="breadcrumb">
            <li class="active">รายชื่อโครงงาน</li>
            <li><a href="javascript:history.back(1)">รายละเอียดของโครงงาน</a></li>
            <li class="active">สรุปผลโครงงาน</li>
        </ol>
    </header>


    <div class="padding-20">
        <div class="table-responsive nomargin">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th data-type="numeric" class="footable-visible footable-sortable footable-sorted" data-sort-initial="asc">กำหนดการ</th>
                        <th data-sort-initial="descending" class="footable-visible footable-sortable" style="width: 10%">คะแนนที่ได้รับ</th>
                        <th data-sort-initial="descending" class="footable-visible footable-sortable" style="width: 10%">คะแนนเต็ม</th>
                        <th data-sort-initial="descending" class="footable-visible footable-sortable" style="width: 10%">สถานะ</th>
                    </tr>
                    </thead>

                    <!-- ----------------------------------------------------------------------------------------------------------------- -->
                    <tbody>
                    <?php
                    foreach ($process_progress as $process_progressn) {
                        foreach ($process_add_con as $process_add_cons) {
                            if ($process_add_cons->process_progress_id == $process_progressn->process_progress_id) {
                                foreach ($process_add as $process_adds) {
                                    if ($process_adds->process_add_id == $process_add_cons->process_add_id) {
                                        ?>
                                        <tr>
                                            <td class="foo-cell"><?= $count . '. ' . $process_adds->process_add_topic ?></td>
                                            <td style=" text-align:center;"><?= $process_progressn->process_progress_score ?></td>
                                            <td style=" text-align:center;"><?= $process_progressn->process_progress_score_full ?></td>
                                            <td style=" text-align:center;">
                                                    <?php if($process_progressn->process_progress_status_id == 1){ ?>
                                                    <span class="label label-success">เสร็จสิ้น<span>
                                                    <?php }elseif ($process_progressn->process_progress_status_id == 2){ ?>
                                                    <span class="label label-info">ดำเนินการ<span>
                                                    <?php }elseif($process_progressn->process_progress_status_id == 3){ ?>
                                                    <span class="label label-danger">เกินระยะเวลา<span>
                                                    <?php } ?>
                                            </td>
                                        </tr>
                                        <?php   $score = $score + $process_progressn->process_progress_score;
                                                $score_full = $score_full + $process_progressn->process_progress_score_full;
                                                $count++;
                                    }
                                }
                            }
                        }
                    }?>

                        <tr class="danger">
                            <td class="foo-cell">สรุปผลคะแนนทั้งหมด</td>
                            <td style=" text-align:center;"><?= $score ?></td>
                            <td style=" text-align:center;"><?= $score_full ?></td>
                            <td style=" text-align:center;"></td>
                        </tr>

                </table>

                <div class="margin-top20 pagination text-center"><!-- PAGINATION --></div>

            <!-- ----------------------------------------------------------------------------------------------------------------- -->
            <!-- ----------------------------------------------------------------------------------------------------------------- -->
            <!-- ----------------------------------------------------------------------------------------------------------------- -->

        </div>
    </div>
</section>