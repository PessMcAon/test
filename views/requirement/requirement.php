<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Requirement;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $model app\models\Requirement */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;
$project_id = "";


?>
<section id="middle" >
    <header id="page-header">
        <h1>Project List</h1>
    </header>
    <div class="padding-20">
        <div class="row">
            <ul class="nav">
                <table class="fooTableInit">
                    <thead>
                        <tr>
                            <th class="foo-cell">Title</th>
                            <th data-type="numeric" data-sort-initial="descending" class="">Date</th>
                            <th data-type="text" data-sort-initial="descending" class="">Progress</th>
                            <th data-type="text" data-sort-initial="descending" class="">Rating</th>
                            <th data-type="text" data-sort-initial="descending" class="">Checker</th>
                            <th data-sort-initial="descending" class="footable-visible footable-sortable footable-sorted"></th>
                            <th data-type="text" data-hide = "s600,s1000" class="" >Detail</th>
                        </tr>
                    </thead>

                     <tbody>

    <!-- ----------------------------------------------------------------------------------------------------------------- -->
                    <?php foreach ($requirement as $value):
                            $project_id = $value->project_id;
                        ?>
                        <tr>
                            <td><?= $value->requirement_topic ?></td>
                            <td><?= $value->requirement_date ?></td>
                            <td>ไฟล์งาน</td>
                            <td>
                                <div class="rating rating-4 size-13 width-100">
                                </div>
                            </td>
                            <td>
                                <span class="label label-success">success</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                        data-target="#bs-example-modal-lg-<?= $value->requirement_id ?>">
                                    <i class="fa fa-file-text-o"></i> Edit</button>

    <!-- ////////////////////////////////////////////////////// Edit //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                                <div class="modal fade" id="bs-example-modal-lg-<?= $value->requirement_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- header modal -->
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myLargeModalLabel">Requirement</h4>
                                            </div>
                                            <!-- body modal -->
                                            <div class="modal-body">
                                                <form action="<?= Yii::$app->homeUrl ?>requirement/requirement_update" method="post" enctype="multipart/form-data">
                                                    <fieldset>
                                                        <!-- required [php action request] -->
                                                        <input type="hidden" name="project_id" value="<?= $project_id ?>" />
                                                        <input type="hidden" name="requirement_id" value="<?= $value->requirement_id ?>" />

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <label>Title</label>
                                                                    <input type="text" name="requirement_topic_edit" id="requirement_topic_edit" value="<?= $value->requirement_topic ?>" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <label>Detail</label>
                                                                    <textarea name="requirement_detail_edit" id="requirement_detail_edit"  rows="4" class="form-control"><?= $value->requirement_detail ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <label>Date</label>
                                                                    <input type="text" name="requirement_date_edit" id="requirement_date_edit" value="<?= $value->requirement_date ?>" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label>
                                                                        File Attachment
                                                                        <small class="text-muted">Curriculum Vitae - optional</small>
                                                                    </label>

                                                                    <!-- custom file upload -->
                                                                    <input class="custom-file-upload" name="requirement[file]" type="file" id="file" data-btn-text="Select a File" />
                                                                    <small class="text-muted block">Max file size: 10Mb (zip/pdf/jpg/png)</small>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- ------ foot -------- -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" href="<?= Yii::$app->homeUrl ?>requirement/requirement_add" class="btn btn-primary">Edit</button>
                                                        </div>
                                                    </div>

                                                    <!-- ------ foot -------- -->
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


    <!-- ////////////////////////////////////////////////////// End Edit ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                                <?= Html::a(' Delete', ['requirement/requirement_delete',
                                    'requirement_id' => $value->requirement_id ,
                                    'project_id' => $value->project_id],
                                    ['class' => 'btn btn-default btn-xs fa fa-close'])
                                ?>

                                <?= Html::a(' Edit PDF', ['requirement/requirement',
                                    'id' => $value->requirement_id ,
                                    'project_id' => $value->project_id],
                                    ['class' => 'btn btn-default btn-xs fa fa-object-group']) ?>
                            </td>
                            <td style="display: none;" ><?= $value->requirement_detail ?></td>
                        </tr>
                    <?php endforeach; ?>
    <!-- ------------------------------------------------------------------------------------------------------------------ -->

                     </tbody>
                </table>
            </ul>
            <br>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bs-example-modal-lg"><i class="et-clipboard"></i> Add Requirement</button>

    <!-- ------------------------------------------------------------------------------------------------------------------ -->

    <!-- ////////////////////////////////////////////////////// ADD /////////////////////////////////////////////////////// -->

            <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- header modal -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myLargeModalLabel">Requirement</h4>
                        </div>
                        <!-- body modal -->
                        <div class="modal-body">
                            <form action="<?= Yii::$app->homeUrl ?>requirement/requirement_add" method="post" enctype="multipart/form-data">
                                <fieldset>
                                    <!-- required [php action request] -->
                                    <input type="hidden" name="project_id" value="<?= $project_id ?>" />

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>Title</label>
                                                <input type="text" name="requirement_topic_form" id="requirement_topic_form" value="" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>Detail</label>
                                                <textarea name="requirement_detail_form" id="requirement_detail_form" rows="4" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6">
                                                <label>Date</label>
                                                <input type="text" name="requirement_date_form" id="requirement_date_form" value="" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>
                                                    File Attachment
                                                    <small class="text-muted">Curriculum Vitae - optional</small>
                                                </label>

                                                <!-- custom file upload -->
                                                <input class="custom-file-upload" name="requirement[file]" type="file" id="file" data-btn-text="Select a File" />
                                                <small class="text-muted block">Max file size: 10Mb (zip/pdf/jpg/png)</small>

                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- ------ foot -------- -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" href="<?= Yii::$app->homeUrl ?>requirement/requirement_add" class="btn btn-primary">Add</button>
                                    </div>
                                </div>

                                <!-- ------ foot -------- -->

                            </form>
                        </div>
                    </div>
                </div>
            </div>







