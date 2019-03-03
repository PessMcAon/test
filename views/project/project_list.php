<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\ProjectConnect;
use app\models\Student;
use app\models\Subjects;
use app\models\StudentDept;

$session = Yii::$app->session;
$session->remove('sesValue');

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */

Yii::$app->view->params['title'] = 'Project List';
$dept_check = 0;
$project_con_check = 0;
$project_check_n = 0;
$degree_check = 0;
?>

<section id="middle">
    <header id="page-header">
        <h1>รายชื่อโครงงาน</h1>
        <ol class="breadcrumb">
            <li class="active">รายชื่อโครงงาน</li>

        </ol>
    </header>
    <div class="padding-20">
        <div id="panel-1" class="panel panel-default">
            <div class="panel-heading">
                <span class="title elipsis">
                    <strong>รายการโครงงาน</strong>
                    <span style="padding: 710px"><?= $session->get('name') ?></span>
                </span>

            </div>

            <div class="panel-body">
                <div style="margin-top: 10px;
                            margin-left: 5px">
                    <div class="btn-group">
                        <?php
                        $subjects = Subjects::find()->all();
                        ?>
                        <button type="button" class="btn btn-default" style="width:480px; text-align:left;" ><i class="fa fa-edit"></i><?= $subject_name ?></button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= Yii::$app->homeUrl ?>project/project_all_subject?teacher_id=<?= $session['pfc_id'] ?>&dept_id=<?= $dept_id ?>&type_degree=<?= $type_degree ?>">
                                    <i class="fa fa-edit"></i> รายการทั้งหมด</a>
                            </li>
                            <?php
                            foreach ($subjects as $subjects_q):
                                ?>
                                <li><a href="<?= Yii::$app->homeUrl ?>project/project_dept_subject?teacher_id=<?= $session['pfc_id'] ?>&subject_id=<?= $subjects_q['subjects_id']?>&dept_id=<?= $dept_id ?>&type_degree=<?= $type_degree ?>">
                                        <i class="fa fa-edit"></i> <?= $subjects_q['subjects_code'].' '.$subjects_q['subjects_name_eng'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <?php
                        $dept_type = StudentDept::find()->all();
                        ?>
                        <button type="button" class="btn btn-default" style="width:100px; text-align:left;" ><i class="fa fa-edit"></i><?= $dept_name ?></button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= Yii::$app->homeUrl ?>project/project_all_dept?teacher_id=<?= $session['pfc_id'] ?>&subject_id=<?= $subject_id ?>&type_degree=<?= $type_degree ?>">
                                    <i class="fa fa-edit"></i> รายการทั้งหมด</a>
                            </li>

                            <?php
                            foreach ($dept_type as $value3):
                                ?>
                                <li><a href="<?= Yii::$app->homeUrl ?>project/project_dept_subject?teacher_id=<?= $session['pfc_id'] ?>&subject_id=<?= $subject_id ?>&dept_id=<?= $value3['student_dept_id'] ?>&type_degree=<?= $type_degree ?>">
                                        <i class="fa fa-edit"></i> <?= $value3['student_dept_name'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>

                <div class="padding-20">
                    <div class="row">
                        <ul class="nav">
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                <tr>
                                    <th style="width: 90%">Project Name</th>
                                    <th>Progress</th>
                                    <th style=" text-align:center;">Detail</th>
                                </tr>
                                </thead>
                                <tbody>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
                                                                <!-- ป.ตรี -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->

                                <?php if($type_degree == 1){
                                if ($dept_id == 0):
                                    $student_c = Student::find()->where("student_degree_id like :b", [":b" => 1])->all();
                                    foreach ($project as $projects):
                                        foreach ($project_con as $project_cons):
                                            if($project_cons->project_id == $projects->project_id) {
                                                $project_con_check = 1;
                                                foreach ($student_c as $student_cs):
                                                    if($student_cs->student_id == $project_cons->student_id) {
                                                        $degree_check = 1;
                                                    }
                                                endforeach;
                                            }
                                        endforeach;
                                        if($degree_check == 1):
                                        if($project_con_check == 1):?>
                                            <tr>
                                                <td> <?= $projects->project_name_th ?></td>
                                                <td>
                                                    <span class="easyPieChart" data-percent="<?= $projects->project_progress ?>" data-easing="easeOutBounce"
                                                          data-barColor="
                                                                  <?php if($projects->project_progress <= 25 ){ ?>
                                                                        #ef1e25
                                                                  <?php }elseif($projects->project_progress <= 60 ){ ?>
                                                                        #FFD700
                                                                  <?php }else{ ?>
                                                                        #008000
                                                                  <?php } ?>"
                                                          data-trackColor="#dddddd" data-scaleColor="#dddddd" data-size="60" data-lineWidth="6">
                                                        <span class="percent"></span>
                                                    </span>
                                                </td>
                                                <td style=" text-align:center;">
                                                    <a href="<?= Yii::$app->homeUrl ?>project/project_detail?project_id=<?= $projects->project_id ?>&id=<?= $session['pfc_id'] ?>&type_degree=<?= $type_degree ?>"
                                                       class="btn btn-3d btn-reveal btn-red">
                                                        <span>Detail</span>
                                                        <i class="et-browser"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endif; $project_con_check =0; ?>
                                        <?php endif; $degree_check =0; ?>
                                    <?php endforeach; ?>
                                <?php else:
                                    foreach ($project as $projects):
                                        $student = null;
                                        $degree_check =0;
                                        foreach ($project_con as $project_cons):
                                            if($project_cons->project_id == $projects->project_id):
                                                $student = Student::find()->where("student_id like :b",[":b"=>$project_cons->student_id])->all();
                                                $student_c = Student::find()->where("student_degree_id like :b", [":b" => 1])->all();
                                                foreach ($student as $students):
                                                    $dept_check = 0;
                                                    $project_check[0] = null;
                                                    $project_check_n++;
                                                    $project_check[$project_check_n] = $projects->project_id;
                                                    foreach ($project_check as $project_checks):
                                                        if($project_check[$project_check_n] != $project_check[$project_check_n-1]){
                                                            if($students['student_dept_id'] == $dept_id){
                                                                $dept_check = 1;
                                                            }
                                                        }
                                                    endforeach;
                                                    foreach ($student_c as $student_cs):
                                                        if($student_cs->student_id == $project_cons->student_id) {
                                                            $degree_check = 1;
                                                        }
                                                    endforeach;
                                                     if($project_con[0]->teacher_id == $session->get('pfc_id')):
                                                        if($degree_check == 1):
                                                        if ($dept_check == 1): ?>
                                                        <tr>
                                                            <td> <?= $projects->project_name_th ?></td>
                                                            <td >
                                                                    <span class="easyPieChart" data-percent="<?= $projects->project_progress ?>" data-easing="easeOutBounce"
                                                                          data-barColor="
                                                                                          <?php if($projects->project_progress <= 25 ){ ?>
                                                                                               #ef1e25
                                                                                          <?php }elseif($projects->project_progress <= 60 ){ ?>
                                                                                               #FFD700
                                                                                          <?php }else{ ?>
                                                                                               #008000
                                                                                           <?php } ?>"

                                                                          data-trackColor="#dddddd" data-scaleColor="#dddddd" data-size="60" data-lineWidth="6">
                                                                        <span class="percent"></span>
                                                                    </span>
                                                            </td>
                                                            <td style=" text-align:center;">
                                                                <a href="<?= Yii::$app->homeUrl ?>project/project_detail?project_id=<?= $projects->project_id ?>&id=<?= $session['pfc_id'] ?>&type_degree=<?= $type_degree ?>"
                                                                   class="btn btn-3d btn-reveal btn-red">
                                                                    <span>Detail</span>
                                                                    <i class="et-browser"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php endif; $degree_check =0; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php } ?>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
                                                                 <!--  ป.โท -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->


                                <?php if($type_degree == 2){
                                    if ($dept_id == 0):
                                        $student_c = Student::find()->where("student_degree_id like :b", [":b" => 2])->all();
                                        foreach ($project as $projects):
                                            foreach ($project_con as $project_cons):
                                                if($project_cons->project_id == $projects->project_id) {
                                                    $project_con_check = 1;
                                                    foreach ($student_c as $student_cs):
                                                        if($student_cs->student_id == $project_cons->student_id) {
                                                            $degree_check = 1;
                                                        }
                                                    endforeach;
                                                }
                                            endforeach;
                                            if($degree_check == 1):
                                                if($project_con_check == 1):?>
                                                    <tr>
                                                        <td> <?= $projects->project_name_th ?></td>
                                                        <td>
                                                    <span class="easyPieChart" data-percent="<?= $projects->project_progress ?>" data-easing="easeOutBounce"
                                                          data-barColor="
                                                                  <?php if($projects->project_progress <= 25 ){ ?>
                                                                        #ef1e25
                                                                  <?php }elseif($projects->project_progress <= 60 ){ ?>
                                                                        #FFD700
                                                                  <?php }else{ ?>
                                                                        #008000
                                                                  <?php } ?>"
                                                          data-trackColor="#dddddd" data-scaleColor="#dddddd" data-size="60" data-lineWidth="6">
                                                        <span class="percent"></span>
                                                    </span>
                                                        </td>
                                                        <td style=" text-align:center;">
                                                            <a href="<?= Yii::$app->homeUrl ?>project/project_detail?project_id=<?= $projects->project_id ?>&id=<?= $session['pfc_id'] ?>&type_degree=<?= $type_degree ?>"
                                                               class="btn btn-3d btn-reveal btn-red">
                                                                <span>Detail</span>
                                                                <i class="et-browser"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endif; $project_con_check =0; ?>
                                            <?php endif; $degree_check =0; ?>
                                        <?php endforeach; ?>
                                    <?php else:
                                        foreach ($project as $projects):
                                            $student = null;
                                            $degree_check =0;
                                            foreach ($project_con as $project_cons):
                                                if($project_cons->project_id == $projects->project_id):
                                                    $student = Student::find()->where("student_id like :b",[":b"=>$project_cons->student_id])->all();
                                                    $student_c = Student::find()->where("student_degree_id like :b", [":b" => 2])->all();
                                                    foreach ($student as $students):
                                                        $dept_check = 0;
                                                        $project_check[0] = null;
                                                        $project_check_n++;
                                                        $project_check[$project_check_n] = $projects->project_id;
                                                        foreach ($project_check as $project_checks):
                                                            if($project_check[$project_check_n] != $project_check[$project_check_n-1]){
                                                                if($students['student_dept_id'] == $dept_id){
                                                                    $dept_check = 1;
                                                                }
                                                            }
                                                        endforeach;
                                                        foreach ($student_c as $student_cs):
                                                            if($student_cs->student_id == $project_cons->student_id) {
                                                                $degree_check = 1;
                                                            }
                                                        endforeach;
                                                        if($project_con[0]->teacher_id == $session->get('pfc_id')):
                                                            if($degree_check == 1):
                                                                if ($dept_check == 1): ?>
                                                                    <tr>
                                                                        <td> <?= $projects->project_name_th ?></td>
                                                                        <td >
                                                                    <span class="easyPieChart" data-percent="<?= $projects->project_progress ?>" data-easing="easeOutBounce"
                                                                          data-barColor="
                                                                                          <?php if($projects->project_progress <= 25 ){ ?>
                                                                                               #ef1e25
                                                                                          <?php }elseif($projects->project_progress <= 60 ){ ?>
                                                                                               #FFD700
                                                                                          <?php }else{ ?>
                                                                                               #008000
                                                                                           <?php } ?>"

                                                                          data-trackColor="#dddddd" data-scaleColor="#dddddd" data-size="60" data-lineWidth="6">
                                                                        <span class="percent"></span>
                                                                    </span>
                                                                        </td>
                                                                        <td style=" text-align:center;">
                                                                            <a href="<?= Yii::$app->homeUrl ?>project/project_detail?project_id=<?= $projects->project_id ?>&id=<?= $session['pfc_id'] ?>&type_degree=<?= $type_degree ?>"
                                                                               class="btn btn-3d btn-reveal btn-red">
                                                                                <span>Detail</span>
                                                                                <i class="et-browser"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endif; $degree_check =0; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php } ?>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
                                                                    <!--  ป.เอก --
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->

                                <?php if($type_degree == 3){
                                    if ($dept_id == 0):
                                        $student_c = Student::find()->where("student_degree_id like :b", [":b" => 3])->all();
                                        foreach ($project as $projects):
                                            foreach ($project_con as $project_cons):
                                                if($project_cons->project_id == $projects->project_id) {
                                                    $project_con_check = 1;
                                                    foreach ($student_c as $student_cs):
                                                        if($student_cs->student_id == $project_cons->student_id) {
                                                            $degree_check = 1;
                                                        }
                                                    endforeach;
                                                }
                                            endforeach;
                                            if($degree_check == 1):
                                                if($project_con_check == 1):?>
                                                    <tr>
                                                        <td> <?= $projects->project_name_th ?></td>
                                                        <td>
                                                    <span class="easyPieChart" data-percent="<?= $projects->project_progress ?>" data-easing="easeOutBounce"
                                                          data-barColor="
                                                                  <?php if($projects->project_progress <= 25 ){ ?>
                                                                        #ef1e25
                                                                  <?php }elseif($projects->project_progress <= 60 ){ ?>
                                                                        #FFD700
                                                                  <?php }else{ ?>
                                                                        #008000
                                                                  <?php } ?>"
                                                          data-trackColor="#dddddd" data-scaleColor="#dddddd" data-size="60" data-lineWidth="6">
                                                        <span class="percent"></span>
                                                    </span>
                                                        </td>
                                                        <td style=" text-align:center;">
                                                            <a href="<?= Yii::$app->homeUrl ?>project/project_detail?project_id=<?= $projects->project_id ?>&id=<?= $session['pfc_id'] ?>&type_degree=<?= $type_degree ?>"
                                                               class="btn btn-3d btn-reveal btn-red">
                                                                <span>Detail</span>
                                                                <i class="et-browser"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endif; $project_con_check =0; ?>
                                            <?php endif; $degree_check =0; ?>
                                        <?php endforeach; ?>
                                    <?php else:
                                        foreach ($project as $projects):
                                            $student = null;
                                            $degree_check =0;
                                            foreach ($project_con as $project_cons):
                                                if($project_cons->project_id == $projects->project_id):
                                                    $student = Student::find()->where("student_id like :b",[":b"=>$project_cons->student_id])->all();
                                                    $student_c = Student::find()->where("student_degree_id like :b", [":b" => 3])->all();
                                                    foreach ($student as $students):
                                                        $dept_check = 0;
                                                        $project_check[0] = null;
                                                        $project_check_n++;
                                                        $project_check[$project_check_n] = $projects->project_id;
                                                        foreach ($project_check as $project_checks):
                                                            if($project_check[$project_check_n] != $project_check[$project_check_n-1]){
                                                                if($students['student_dept_id'] == $dept_id){
                                                                    $dept_check = 1;
                                                                }
                                                            }
                                                        endforeach;
                                                        foreach ($student_c as $student_cs):
                                                            if($student_cs->student_id == $project_cons->student_id) {
                                                                $degree_check = 1;
                                                            }
                                                        endforeach;
                                                        if($project_con[0]->teacher_id == $session->get('pfc_id')):
                                                            if($degree_check == 1):
                                                                if ($dept_check == 1): ?>
                                                                    <tr>
                                                                        <td> <?= $projects->project_name_th ?></td>
                                                                        <td >
                                                                    <span class="easyPieChart" data-percent="<?= $projects->project_progress ?>" data-easing="easeOutBounce"
                                                                          data-barColor="
                                                                                          <?php if($projects->project_progress <= 25 ){ ?>
                                                                                               #ef1e25
                                                                                          <?php }elseif($projects->project_progress <= 60 ){ ?>
                                                                                               #FFD700
                                                                                          <?php }else{ ?>
                                                                                               #008000
                                                                                           <?php } ?>"

                                                                          data-trackColor="#dddddd" data-scaleColor="#dddddd" data-size="60" data-lineWidth="6">
                                                                        <span class="percent"></span>
                                                                    </span>
                                                                        </td>
                                                                        <td style=" text-align:center;">
                                                                            <a href="<?= Yii::$app->homeUrl ?>project/project_detail?project_id=<?= $projects->project_id ?>&id=<?= $session['pfc_id'] ?>&type_degree=<?= $type_degree ?>"
                                                                               class="btn btn-3d btn-reveal btn-red">
                                                                                <span>Detail</span>
                                                                                <i class="et-browser"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endif; $degree_check =0; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php } ?>
                            </table>
                        </ul>

                        <!-- ----------------------------------------------------------------------------------------------------------------- -->
                        <!-- ----------------------------------------------------------------------------------------------------------------- -->
                        <!-- ----------------------------------------------------------------------------------------------------------------- -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

