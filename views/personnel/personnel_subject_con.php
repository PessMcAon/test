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
$check_process_add = null;
?>


<section id="middle">
    <header id="page-header">
        <h1>กำหนดความสัมพันธ์รายวิชา</h1>
        <ol class="breadcrumb">
            <li class="active">หน้าหลัก</a></li>
            <li class="active">เลือกวิชาที่ต้องการสร้างกำหนดการ</li>
        </ol>
    </header>

    <div class="panel-body">
        <div class="padding-20">
            <?php $subject_c = Subjects::findOne($subject_choose); ?>
            <span>เลือกวิชาที่ต้องการกำหนดความสัมพันธ์ กับวิชา <?= $subject_c->subjects_name_thai ?></span>
            <form action="<?= Yii::$app->homeUrl ?>personnel/personnel_gantt_type_add" method="post" name="myForm"
                  onsubmit="return validateForm()" enctype="multipart/form-data" >
                <input type="hidden" name="type_degree" value="<?= $type_degree ?>" />
                <input type="hidden" name="subject_choose" value="<?= $subject_choose ?>" />
                <input type="hidden" name="check_null" value="<?= $check_null ?>" />
                <input type="hidden" name="check_create" value="<?= 2 ?>" />
                <div class="fancy-form fancy-form-select" style="margin-top: 15px">
                    <select class="form-control select2" name="subject_connect">
                        <option value="">--- เลือกรายวิชา ---</option>
                        <?php foreach ($subject as $subjects){ ?>
                            <?php if ($subjects->subjects_id != $subject_choose){ ?>
                                <option value="<?= $subjects->subjects_id ?>"><?= $subjects->subjects_name_thai ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <i class="fancy-arrow"></i>
                </div>
                <?php if($check_null == '0'){ ?>
                    <font color='#ff0000'>*กรุณาเลือกวิชาที่ต้องการกำหนดความสัมพันธ์ </font>
                <?php } ?>
                <div class="row"
                     style="margin-top: 20px;">
                    <div class="col-md-12">
                        <button type="submit" href="<?= Yii::$app->homeUrl ?>personnel/personnel_gantt_type_add" class="btn btn-green">ตกลง</button>
                        <a type="button" href="<?= Yii::$app->homeUrl ?>personnel/personnel_subject?type_degree=<?= $type_degree ?>" class="btn btn-default" data-dismiss="modal">ถอยกลับ</a>
                    </div>
                </div>
            </form>
        </div>

    </div>



</section>


<script type="text/javascript" >
    function validateForm() {
        var x=document.forms["myForm"]["subject_connect"].value;
        if (x==null || x=="") {
            alert("กรุณาเลือกวิชาที่ต้องการกำหนดความสัมพันธ์");
            return false;
        }
    }

</script>



