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
$count = 1;
?>

<section id="middle">
    <header id="page-header">
        <h1>Project Summary</h1>
    </header>
    <div class="padding-20">
        <div id="panel-misc-portlet-l2" class="panel panel-default">

            <div class="panel-heading">
                <ul class="nav nav-tabs pull-left">
                    <li class="active"><!-- TAB 1 -->
                        <a href="#ttab1_nobg" data-toggle="tab">ผลสรุปคะแนนของโครงงาน</a>
                    </li>
                    <li class=""><!-- TAB 2 -->
                        <a href="#ttab2_nobg" data-toggle="tab">ใบเข้าพบอาจารย์ที่ปรึกษา</a>
                    </li>
                </ul>

            </div>

            <div class="panel-body">
                <div class="tab-content transparent">

                    <div id="ttab1_nobg" class="tab-pane active"><!-- TAB 1 CONTENT -->
                        <div class="table-responsive nomargin">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th data-type="numeric" class="footable-visible footable-sortable footable-sorted" data-sort-initial="asc">กำหนดการ</th>
                                    <th data-sort-initial="descending" class="footable-visible footable-sortable" style="width: 11%">คะแนนที่ได้รับ</th>
                                    <th data-sort-initial="descending" class="footable-visible footable-sortable" style="width: 11%">คะแนนเต็ม</th>
                                </tr>
                                </thead>

                                <!-- ----------------------------------------------------------------------------------------------------------------- -->
                                <tbody>
                                <?php
                                foreach ($process as $process1):
                                    $gantt_id = $process1['process_grantt_id'];
                                    ?>
                                    <tr>
                                        <td class="foo-cell"><?= $count.'. '.$process_gantt[$gantt_id-1]->process_grantt_topic ?></td>
                                        <td style=" text-align:center;">10</td>
                                        <td style=" text-align:center;">10</td>
                                    </tr>
                                    <?php $count++; endforeach; ?>

                                <tr class="danger">
                                    <td class="foo-cell">สรุปผลคะแนนทั้งหมด</td>
                                    <td style=" text-align:center;">100</td>
                                    <td style=" text-align:center;">100</td>
                                </tr>

                            </table>

                            <div class="margin-top20 pagination text-center"><!-- PAGINATION --></div>

                            <!-- ----------------------------------------------------------------------------------------------------------------- -->
                            <!-- ----------------------------------------------------------------------------------------------------------------- -->
                            <!-- ----------------------------------------------------------------------------------------------------------------- -->

                        </div>
                    </div><!-- /TAB 1 CONTENT -->

                    <div id="ttab2_nobg" class="tab-pane"><!-- TAB 2 CONTENT -->
                        <div class="table-responsive nomargin">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th data-sort-initial="descending" class="footable-visible footable-sortable" style="width: 15%">วันที่เข้าพบ</th>
                                    <th data-type="numeric" class="footable-visible footable-sortable footable-sorted" data-sort-initial="asc">กำหนดการ</th>
                                    <th data-sort-initial="descending" class="footable-visible footable-sortable" style="width: 11%">คะแนนเต็ม</th>
                                </tr>
                                </thead>

                                <!-- ----------------------------------------------------------------------------------------------------------------- -->
                                <tbody>
                                    <tr>
                                        <td class="foo-cell"></td>
                                        <td style=" text-align:center;"></td>
                                        <td style=" text-align:center;"></td>
                                    </tr>

                                    <tr class="danger">
                                        <td class="foo-cell">สรุปผลคะแนนทั้งหมด</td>
                                        <td style=" text-align:center;">100</td>
                                        <td style=" text-align:center;">100</td>
                                    </tr>

                            </table>

                            <div class="margin-top20 pagination text-center"><!-- PAGINATION --></div>

                            <!-- ----------------------------------------------------------------------------------------------------------------- -->
                            <!-- ----------------------------------------------------------------------------------------------------------------- -->
                            <!-- ----------------------------------------------------------------------------------------------------------------- -->

                        </div>                    </div><!-- /TAB 1 CONTENT -->

                </div>
            </div>

        </div>


    </div>
</section>