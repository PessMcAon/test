<?php

use app\models\Student;
use app\models\ProjectConnect;


Yii::$app->view->params['title'] = 'Home'

?>

<section id="middle" class="section">
    <header id="page-header">
        <h1><?= $this->params['title'] ?></h1>
    </header>

    <?php
//    foreach ($project_con as $project_cons):
//        foreach ($student as $students):
//            if($students->student_id == $project_cons->student_id):
//                echo $students->student_id;
//            endif;
//        endforeach;
//    endforeach;
    $check_process_add = null;
    foreach ($process_progress as $process_progressn){
        foreach ($process_gantt_con as $process_gantt_cons) {
            foreach ($process_add_con as $process_add_cons) {
                if ($process_gantt_cons->process_progress_id == $process_progressn->process_progress_id) {
                    foreach ($process_gantt as $process_gantts) {
                        if ($process_gantts->process_gantt_id == $process_gantt_cons->process_gantt_id) {
                            echo $process_gantts->process_gantt_topic;
                            ?> <br><?php
                        }
                    }

    }elseif ($process_add_cons->process_progress_id == $process_progressn->process_progress_id
        and $process_add_cons->process_progress_id != $check_process_add){
    $check_process_add = $process_add_cons->process_progress_id;
            foreach ($process_add as $process_adds) {
                if ($process_adds->process_add_id == $process_add_cons->process_add_id) {
                    echo $process_adds->process_add_topic;
                    ?> <br><?php
                }
            }
        }
    }

     }

    }



//    foreach ($process_progress as $process_progressn){
//        echo $process_progressn->process_progress_id;
//    }

//    foreach ($process_gantt_con as $process_gantt_cons) {
//        echo $process_gantt_cons->process_progress_id;
//    }


    ?>


</section>
