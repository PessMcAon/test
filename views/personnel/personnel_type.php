<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\StudentDept;
use app\models\StudentDegree;
use app\models\PersonnelFile;


$session = Yii::$app->session;
$session->remove('sesValue');

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */

Yii::$app->view->params['title'] = 'Project List';

$count_no = 1;
$check_process_add = null;
?>


<section id="middle">
    <header id="page-header">
        <h1>เพิ่มกำหนดการ</h1>
        <ol class="breadcrumb">
            <li class="active">หน้าหลัก</li>
        </ol>
    </header>
    <div class="panel-body">
        <div class="padding-20">

            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="box leaf">
                        <div class="box-title">
                            <h4>Upload File</h4>
                            <small class="block">อัพโหลดไฟล์ เอกสารเข้าพบอาจารย์ที่ปรึกษา</small>
                            <i class="fa fa-download"></i>
                        </div>


                        <button type="button"
                                class="btn btn-featured btn-primary"
                                data-toggle="modal"
                                data-target="#bs-example-modal-lg-upload">
                            <span>Upload</span>
                            <i class="et-upload"></i>
                        </button>
                    </div>
                </div>


                <div class="col-md-3 col-sm-6">
                    <?php $personnel_file = PersonnelFile::find()->all(); ?>
                    <?php if($personnel_file != null){ ?>
                        <div class="box success">
                    <?php }else{ ?>
                        <div class="box danger">
                    <?php } ?>
                        <div class="box-title">
                            <h4>File</h4>
                            <small class="block">
                                <?php if($personnel_file != null){ ?>
                                    อัพโหลดไฟล์เรียบร้อย
                                <?php }else{ ?>
                                    ไม่มีไฟล์ที่อัพโหลด
                                <?php } ?>
                            </small>
                            <i class="fa fa-download"></i>
                        </div>

                        <div class="box-body text-center">
                            <?php if($personnel_file != null){ ?>
                                <a href="<?= Yii::$app->homeUrl ?>personnel/personnel_download?fileupload=<?= $personnel_file[0]->personnel_file_pro ?>"
                                   class="btn btn-green"
                                   style="margin-top: 10px">
                                    <span><?= $personnel_file[0]->personnel_file_name ?></span>
                                </a>
                            <?php }else{ ?>
                                <button type="button"
                                        class="btn btn-red"
                                        data-toggle="modal"
                                        style="margin-top: 10px">
                                    ไม่มีไฟล์ที่อัพโหลด
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>


                    <div class="col-md-3 col-sm-6">
                        <div class="box info">
                            <div class="box-title">
                                <h4>Calendar</h4>
                                <small class="block">ปฎิทินการดูแล</small>
                                <i class="fa fa fa-calendar"></i>
                            </div>


                            <a href="<?= Yii::$app->homeUrl ?>calendar/calendar"
                               class="btn btn-featured btn-blue">
                                <span>Calendar</span>
                                <i class="et-calendar"></i>
                            </a>
                            </button>
                        </div>
                    </div>

            </div>


            <div class="row">

                <div class="col-md-3 col-sm-6">
                    <div class="box danger">
                        <div class="box-title">
                            <h4>ปริญญาตรี</h4>
                            <small class="block">โครงงานปริญญาตรี</small>
                            <i class="fa fa-bookmark"></i>
                        </div>

                        <a href="<?= Yii::$app->homeUrl ?>personnel/personnel_subject?type_degree=1"
                           class="btn btn-featured btn-red">
                            <span>ปริญญาตรี</span>
                            <i class="et-presentation"></i>
                        </a>
                    </div>
                </div>



                <div class="col-md-3 col-sm-6">
                    <div class="box warning">
                        <div class="box-title">
                            <h4>ปริญญาโท</h4>
                            <small class="block">โครงงานปริญญาโท</small>
                            <i class="fa fa-bar-chart-o"></i>
                        </div>

                        <a href=""
                           class="btn btn-featured btn-warning">
                            <span>ปริญญาโท</span>
                            <i class="et-browser"></i>
                        </a>
                    </div>
                </div>


                <div class="col-md-3 col-sm-6">
                    <div class="box success">
                        <div class="box-title">
                            <h4>ปริญญาเอก</h4>
                            <small class="block">โครงงานปริญญาเอก</small>
                            <i class="fa fa fa-calendar"></i>
                        </div>

                        <a href=""
                           class="btn btn-featured btn-success">
                            <span>ปริญญาเอก</span>
                            <i class="et-briefcase"></i>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>

</section>


<!-- ////////////////////////////////////////////////////// Upload progress /////////////////////////////////////////////////////// -->

    <div class="modal fade" id="bs-example-modal-lg-upload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- header modal -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">Upload</h4>
                </div>
                <!-- body modal -->
                <div class="modal-body">
                    <form method=post action="<?= Yii::$app->homeUrl ?>personnel/personnel_upload" enctype="multipart/form-data">

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12">
                                    <label>เฉพาะไฟล์ docx , PDF เท่านั้น</label>
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

<!-- ////////////////////////////////////////////////////// Upload progress /////////////////////////////////////////////////////// -->



