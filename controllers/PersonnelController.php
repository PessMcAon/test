<?php
/**
 * Created by PhpStorm.
 * User: pessm
 * Date: 7/19/2017
 * Time: 3:29 PM
 */

namespace app\controllers;


use Yii;

use app\models\ProcessGanttType;
use app\models\Subjects;
use app\models\ProcessGantt;
use app\models\PersonnelFile;

use yii\web\Controller;

class PersonnelController extends Controller
{

    public  function  actionPersonnel_type(){
        return $this->render('personnel_type', [

        ]);
    }


    public  function  actionPersonnel_gantt_type_add(){
        $gantt_process_choose = ProcessGanttType::find()->where("subjects_id like :b", [":b" => $_REQUEST['subject_choose']])->all();

        if($gantt_process_choose == null ) {
            $gantt_process_con = ProcessGanttType::find()->where("subjects_id like :a", [":a" => $_REQUEST['subject_connect']])->all();
            if ($gantt_process_con == null) {
                if($_REQUEST['check_create'] == 1) {
                    $process_gantt_type_add = New ProcessGanttType();
                    $process_gantt_type_add->process_gantt_tpye_id = $_REQUEST['subject_choose'] . 'gantt_type';
                    $process_gantt_type_add->process_gantt_tpye_code = 'process_gantt_cen_' . date("Ymd") . date("His");
                    $process_gantt_type_add->subjects_id = $_REQUEST['subject_choose'];
                    $process_gantt_type_add->save();

                    return $this->redirect(['personnel_process',
                        'process_gantt_type_id' => 'process_gantt_cen_' . date("Ymd") . date("His"),
                        'type_degree' => (int)$_REQUEST['type_degree'],
                    ]);
                } else {
                    $process_gantt_type_add = New ProcessGanttType();
                    $process_gantt_type_add->process_gantt_tpye_id = $_REQUEST['subject_choose'] . 'gantt_type';
                    $process_gantt_type_add->process_gantt_tpye_code = 'process_gantt_cen_' . date("Ymd") . date("His");
                    $process_gantt_type_add->subjects_id = $_REQUEST['subject_choose'];
                    $process_gantt_type_add->save();

                    $process_gantt_choose = ProcessGanttType::find()->where("subjects_id like :b", [":b" => $_REQUEST['subject_choose']])->all();
                    $process_gantt_type_add_con = New ProcessGanttType();
                    $process_gantt_type_add_con->process_gantt_tpye_id = $_REQUEST['subject_connect'] . 'gantt_type';
                    $process_gantt_type_add_con->process_gantt_tpye_code = $process_gantt_choose[0]->process_gantt_tpye_code;
                    $process_gantt_type_add_con->subjects_id = $_REQUEST['subject_connect'];
                    $process_gantt_type_add_con->save();

                    return $this->redirect(['personnel_process',
                        'process_gantt_type_id' => $process_gantt_choose[0]->process_gantt_tpye_code,
                        'type_degree' => (int)$_REQUEST['type_degree'],
                    ]);
                }

            } else {
                $gantt_process_con = ProcessGanttType::find()->where("subjects_id like :b", [":b" => $_REQUEST['subject_connect']])->all();
                $process_gantt_type_add_con = New ProcessGanttType();
                $process_gantt_type_add_con->process_gantt_tpye_id = $_REQUEST['subject_choose'] . 'gantt_type';
                $process_gantt_type_add_con->process_gantt_tpye_code = $gantt_process_con[0]->process_gantt_tpye_code;
                $process_gantt_type_add_con->subjects_id = $_REQUEST['subject_choose'];
                $process_gantt_type_add_con->save();

                return $this->redirect(['personnel_process',
                    'process_gantt_type_id' => $gantt_process_con[0]->process_gantt_tpye_code,
                    'type_degree' => (int)$_REQUEST['type_degree'],
                ]);
            }

        } else {
            return $this->redirect(['personnel_process',
                'process_gantt_type_id' => $gantt_process_choose[0]->process_gantt_tpye_code,
                'type_degree' => (int)$_REQUEST['type_degree'],
            ]);
        }
    }


    public  function  actionPersonnel_process(){
        $process_gantt = ProcessGantt::find()->where("process_gantt_type_code like :b", [":b" => $_REQUEST['process_gantt_type_id']])->orderBy(['process_gantt_no'=>SORT_ASC])->all();
        $start_date_constant = null;

        if($process_gantt != null) {
            $start_date_constant = $process_gantt[0]->process_gantt_date_start;
        }

        return $this->render('personnel_process', [
            'process_gantt_type_id' => $_REQUEST['process_gantt_type_id'],
            'process_gantt' => $process_gantt,
            'start_date_constant' => $start_date_constant,
            'type_degree' => $_REQUEST['type_degree'],
        ]);
    }



    public  function  actionPersonnel_process_add(){
        $process_gantt = ProcessGantt::find()->where("process_gantt_type_code like :b", [":b" => $_REQUEST['process_gantt_type_id']])->orderBy(['process_gantt_no'=>SORT_ASC])->all();
        $typename = null;
        $count_no = 0;

        if($_POST['type_degree'] == 1){
            $typename = 'Bachelor';
        }elseif($_POST['type_degree'] == 2){
            $typename = 'SEMINAR';
        }elseif($_POST['type_degree'] == 3){
            $typename = 'RM';
        }elseif($_POST['type_degree'] == 4){
            $typename = 'Master';
        }elseif($_POST['type_degree'] == 5){
            $typename = 'Doctor';
        }

        foreach ($process_gantt as $process_gantts){
            $count_no++;
        }

        $process_add = New ProcessGantt();
        $process_add->process_gantt_id = 'process_gantt_'.$typename.'_'.($count_no+1);
        $process_add->process_gantt_no = (int)$_POST['process_no_form'];
        $process_add->process_gantt_topic = $_POST['process_topic_form'];
        $process_add->process_gantt_detail = $_POST['process_detail_form'];
        $process_add->process_gantt_score = 0;
        $process_add->process_gantt_type_code = $_REQUEST['process_gantt_type_id'];
        $process_add->process_gantt_date_start = $_POST['process_date_start_form'];
        $process_add->process_gantt_date_end = $_POST['process_date_end_form'];
        $process_add->save();

        return $this->redirect(['personnel_process',
            'type_degree' => $_POST['type_degree'],
            'process_gantt_type_id' => $_REQUEST['process_gantt_type_id'],
        ]);
    }


    public function actionPersonnel_process_edit(){
        $session = Yii::$app->session;
        $count_no = 1;
        $process_gantt = ProcessGantt::find()->where("process_gantt_type_code like :b", [":b" => $_REQUEST['process_gantt_type_id']])->orderBy(['process_gantt_no'=>SORT_ASC])->all();


        foreach ($process_gantt as $process_gantts){
            $count_no = $process_gantts->process_gantt_no;
        }

        $process_edit = ProcessGantt::findOne($_POST['process_gantt_id']);
        $process_edit->process_gantt_no = (int)$_POST['edit_no_form'];
        $process_edit->process_gantt_topic = $_POST['edit_topic_form'];
        $process_edit->process_gantt_detail = $_POST['edit_detail_form'];
        $process_edit->process_gantt_date_start = $_POST['edit_date_start_form'];
        $process_edit->process_gantt_date_end = $_POST['edit_date_end_form'];
        $process_edit->update();

//--------------------------------------------- NO.Change --------------------------------------------------

        if((int)$_POST['edit_no_form'] <= $count_no && (int)$_POST['edit_no_form'] != $process_gantt[0]->process_gantt_no) {
            $count_change_no = (int)$_POST['edit_no_form'];

            foreach ($process_gantt as $process_gantts_no) {
                if ($process_gantts_no->process_gantt_no == $count_change_no) {
                    $process_progress_no_change = ProcessGantt::findOne($process_gantts_no->process_gantt_id);
                    $process_progress_no_change->process_gantt_no = $process_gantts_no->process_gantt_no + 1;
                    $process_progress_no_change->update();
                    $count_change_no++;
                }
            }
        }

        //----------------------------------------------------------------------------------------------------------

        return $this->redirect(['personnel_process',
            'type_degree' => $_POST['type_degree'],
            'process_gantt_type_id' => $_REQUEST['process_gantt_type_id'],
        ]);
    }


    public function actionPersonnel_process_delete(){
        ProcessGantt::findOne($_POST['delete_process_id'])->delete();

        return $this->redirect(['personnel_process',
            'type_degree' => $_POST['type_degree'],
            'process_gantt_type_id' => $_REQUEST['process_gantt_type_id'],
        ]);
    }


    public function actionPersonnel_process_score(){

        $process_gantt_score = ProcessGantt::findOne($_POST['process_gantt_id']);
        $process_gantt_score->process_gantt_score = (int)$_POST['score_full'];;
        $process_gantt_score->update();

        return $this->redirect(['personnel_process',
            'type_degree' => $_POST['type_degree'],
            'process_gantt_type_id' => $_REQUEST['process_gantt_type_id'],
        ]);
    }



    public function actionPersonnel_upload(){
//        echo 'console.log('. json_encode( $data ) .')';
        date_default_timezone_set("Asia/bangkok");
        $session = Yii::$app->session;
        $file_docx = strtolower($_FILES["upload"]["name"]);
        $sur = strrchr($file_docx,".");
        $file_upload_newname = date("Ymd").$time = date("His").$sur;


        if($sur == ".docx" || $sur == ".pdf" || $sur == ".doc") {
            $uploadOk = 1;
        }
        $personnel = PersonnelFile::find()->all();

        if($personnel == null) {
            $personnel_upload = New PersonnelFile();
            $personnel_upload->personnel_file_id = "staff_upload_file";
            $personnel_upload->personnel_file_date = date("Y-m-d") . ' ' . $time = date("H:i:s");
            $personnel_upload->personnel_file_name = $_FILES["upload"]["name"];
            $personnel_upload->personnel_file_pro = $file_upload_newname;
            $personnel_upload->save();

            move_uploaded_file($_FILES["upload"]["tmp_name"], "../fileupload/staff_file/" . $file_upload_newname);

        }else{

            $filedelete = $personnel[0]->personnel_file_pro;

            $personnel_upload_update = PersonnelFile::findOne($personnel[0]->personnel_file_id);
            $personnel_upload_update->personnel_file_date = date("Y-m-d") . ' ' . $time = date("H:i:s");
            $personnel_upload_update->personnel_file_name = $_FILES["upload"]["name"];
            $personnel_upload_update->personnel_file_pro = $file_upload_newname;
            $personnel_upload_update->update();

            @unlink("../fileupload/staff_file/".$filedelete);
            move_uploaded_file($_FILES["upload"]["tmp_name"], "../fileupload/staff_file/" . $file_upload_newname);
        }

        return $this->redirect(['personnel_type',

        ]);

    }


    public function actionPersonnel_download($fileupload){
        $session = Yii::$app->session;
        $file_url = '../fileupload/staff_file/'.$fileupload;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url);

        return $this->redirect(['personnel_type',

        ]);
    }


    public function actionPersonnel_subject($type_degree){
        $subject = Subjects::find()->where("student_degree_id like :b ", [":b" => $type_degree])->all();
        $gantt_process = ProcessGanttType::find()->orderBy('process_gantt_tpye_code' )->all();

        return $this->render('personnel_subject', [
            'subject' => $subject,
            'gantt_process' => $gantt_process,
            'type_degree' => $type_degree,
            'check_null' => '1',
        ]);
    }

    public function actionPersonnel_subject_connect(){
        $gantt_process_choose = ProcessGanttType::find()->where("subjects_id like :b", [":b" => $_POST['subject']])->all();
        $subject = Subjects::find()->where("student_degree_id like :b", [":b" => $_POST['type_degree']])->all();


            if (isset($_POST['save'])) {
                if ($_POST['subject'] == 0) {
                    $check_null = 0;
                    return $this->render('personnel_subject', [
                        'subject' => $subject,
                        'check_null' => $check_null,
                        'type_degree' => $_POST['type_degree'],
                    ]);
                } else {
                    return $this->redirect(['personnel_gantt_type_add',
                        'subject_choose' => $_POST['subject'],
                        'subject_connect' => '0',
                        'type_degree' => $_POST['type_degree'],
                        'check_create' => 1,
                    ]);
                }
            } elseif ($_POST['connect']) {
                if ($gantt_process_choose == null) {
                    if ($_POST['subject'] == 0) {
                        $check_null = 0;
                        return $this->render('personnel_subject', [
                            'subject' => $subject,
                            'check_null' => $check_null,
                            'type_degree' => $_POST['type_degree'],
                        ]);
                    } else {
                        $check_null = 1;
                        return $this->render('personnel_subject_con', [
                            'subject' => $subject,
                            'subject_choose' => $_POST['subject'],
                            'type_degree' => $_POST['type_degree'],
                            'check_null' => $check_null,
                        ]);
                    }
                }else{
                    $check_null = 3;
                    echo "<script type=\"text/javascript\">";
                    echo "alert(\"วิชาที่เลือกถูกเชื่อมความสัมพันธ์แล้ว\");";
                    echo "window.history.back();";
                    echo "</script>";
                    exit();

//                    return $this->render('personnel_subject', [
//                        'subject' => $subject,
//                        'check_null' => $check_null,
//                        'type_degree' => $_POST['type_degree'],
//                    ]);

                }

            }

    }



    public function actionPersonnel_subject_delete($gantt_type,$type_degree){
        $gantt_process = ProcessGanttType::find()->all();
        $subject = Subjects::find()->where("student_degree_id like :b", [":b" => $type_degree])->all();

        ProcessGanttType::findOne($gantt_type)->delete();

        return $this->redirect(['personnel_subject',
            'type_degree' => $type_degree,
        ]);
    }





//***********************************************************************************************************************************
}

