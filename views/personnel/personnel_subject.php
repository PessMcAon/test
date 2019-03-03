<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\StudentDept;
use app\models\StudentDegree;
use app\models\Subjects;


$session = Yii::$app->session;
$session->remove('sesValue');

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */

Yii::$app->view->params['title'] = 'Project List';

$count_no = 1;
$check_connect = '0';
?>


<section id="middle">
    <header id="page-header">
        <h1>เลือกวิชาที่ต้องการสร้างกำหนดการ</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:history.back(1)">หน้าหลัก</a></li>
            <li class="active">เลือกวิชาที่ต้องการสร้างกำหนดการ</li>
        </ol>
    </header>

    <div class="panel-body">
        <div class="padding-20">
            <span>เลือกวิชาที่ต้องการสร้างกำหนดการ</span>
            <form action="<?= Yii::$app->homeUrl ?>personnel/personnel_subject_connect" method="post" name="myForm"
                  onsubmit="return validateForm()"  enctype="multipart/form-data">
                <input type="hidden" name="type_degree" value="<?= $type_degree ?>" />
                <input type="hidden" name="check_null" value="<?= $check_null ?>" />
                <div class="fancy-form fancy-form-select" style="margin-top: 15px">
                    <select class="form-control select2" name="subject">
                        <option value="">--- เลือกรายวิชา ---</option>
                        <?php foreach ($subject as $subjects){ ?>
                            <option value="<?= $subjects->subjects_id ?>"><?= $subjects->subjects_name_thai ?></option>
                        <?php } ?>
                    </select>
                    <i class="fancy-arrow"></i>
                </div>
                <?php if($check_null == '0'){ ?>
                    <span color='#ff0000'>*กรุณาเลือกวิชาที่ต้องการกำหนดความสัมพันธ์ </span>
                <?php }elseif($check_null == '3'){ ?>
                    <span color='#ff0000'>*วิชาที่เลือกถูกเชื่อมความสัมพันธ์แล้ว </span>
                <?php } ?>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <button type="submit" href="<?= Yii::$app->homeUrl ?>personnel/personnel_subject_connect"
                                class="btn btn-green" name="save" value="save">
                            สร้างกำหนดการ
                        </button>
                        <a type="button" href="<?= Yii::$app->homeUrl ?>personnel/personnel_type" class="btn btn-red" >ถอยกลับ</a>
                    </div>

                    <div class="col-md-12"  style="margin-top: 10px;">
                        <button type="submit" href="<?= Yii::$app->homeUrl ?>personnel/personnel_subject_connect"
                                class="btn btn-info" style="width: 197px;" name="connect" value="connect">
                            กำหนดความสัมพันธ์รายวิชา
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="padding-20">
            <span>รายชื่อวิชาที่มีกำหนดการมาตรฐาน</span>
            <div style="margin-top: 10px">
                <table class="table table-bordered nomargin">
                    <thead>
                        <tr>
                            <th width="130px">รหัสวิชา</th>
                            <th width="727px">ชื่อวิชา</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        foreach ($gantt_process as $gantt_processn){
                            $subject = Subjects::find()->where("subjects_id like :b ", [":b" => $gantt_processn->subjects_id])->all();
                            foreach ($subject as $subjects){
                                if($gantt_processn->subjects_id == $gantt_processn->subjects_id){
                                    if($check_connect == $gantt_processn->process_gantt_tpye_code)?>
                                    <tr>
                                        <td><?= $subjects->subjects_code ?></td>
                                        <td><?= $subjects->subjects_name_thai ?></td>
                                        <td>
                                            <a href="<?= Yii::$app->homeUrl ?>personnel/personnel_gantt_type_add?subject_choose=<?= $subjects->subjects_id ?>&type_degree=<?= $type_degree ?>"
                                               class="label label-default">แก้ไขกำหนดการ
                                            </a>

                                            <a href="<?= Yii::$app->homeUrl ?>personnel/personnel_subject_delete?gantt_type=<?= $gantt_processn['process_gantt_tpye_id'] ?>&type_degree=<?= $type_degree ?>"
                                                class="label label-danger" style="margin-left: 7px">ลบกำหนดการ
                                            </a>
                                        </td>
                                    </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</section>




<script type="text/javascript" >
    function validateForm() {
        var x=document.forms["myForm"]["subject"].value;
        if (x==null || x=="") {
            alert("กรุณาเลือกวิชาที่ต้องการกำหนดความสัมพันธ์");
            return false;
        }
    }

</script>



