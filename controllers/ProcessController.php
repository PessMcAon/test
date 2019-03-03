<?php
/**
 * Created by PhpStorm.
 * User: pessm
 * Date: 8/1/2017
 * Time: 9:32 AM
 */

namespace app\controllers;

use app\models\Process;
use app\models\ProcessAddConnect;
use app\models\ProcessProgress;
use app\models\ProcessGantt;
use app\models\Project;
use yii\web\Controller;
use app\models\ProcessRequirement;
use app\models\ProcessAdd;
use app\models\ProcessRequirementConnect;
use app\models\ProcessProgressFile;
use app\models\ProcessProgressConnect;
use Yii;


class ProcessController extends Controller
{

    public function actionProcess($project_id,$type,$id,$type_degree,$process_gantt_type_code){
        $session = Yii::$app->session;
        $session->set('pfc_type_degree', $type_degree);
        if($session->get('pfc_id') != $id){
            $this->redirect(['project/home']);
        }else {
            $process = Process::find()->where("process_gantt_tpye_code like :b AND project_id like :a", [":b" => $process_gantt_type_code,":a" => $project_id])->all();
            $process_progress = ProcessProgress::find()->where("process_id like :b ORDER BY process_progress_no", [":b" => $process[0]->process_id])->all();
            $process_add = ProcessAdd::find()->all();
            $process_add_con = ProcessAddConnect::find()->all();
            $process_requirement = ProcessRequirement::find()->all();
            $project = Project::findOne($project_id);

            if($process_progress != null) {
                $process_progress_id_1 = ProcessAddConnect::find()->where("process_progress_id like :b", [":b" => $process_progress[0]->process_progress_id])->all();
                $start_date_constant_1 = ProcessAdd::find()->where("process_add_id like :b", [":b" => $process_progress_id_1[0]->process_add_id])->all();
                $start_date_constant = $start_date_constant_1[0]->process_add_date_start;

                if ($type == 1) {
                    if ($type_degree == 1) {
                        return $this->render('process_teacher', [
                            'type' => $type,
                            'process' => $process,
                            'process_progress' => $process_progress,
                            'process_add' => $process_add,
                            'process_add_con' => $process_add_con,
                            'process_requirement' => $process_requirement,
                            'start_date_constant' => $start_date_constant,
                            'project_name' => $project->project_name_th,
                            'project_id' => $project_id,
                            'type_degree' =>  $type_degree,
                            'id' => $session['pfc_id']
                        ]);
                    } else {
                        return $this->render('process_teacher_master', [
                            'type' => $type,
                            'process' => $process,
                            'process_progress' => $process_progress,
                            'process_add' => $process_add,
                            'process_add_con' => $process_add_con,
                            'process_requirement' => $process_requirement,
                            'start_date_constant' => $start_date_constant,
                            'project_name' => $project->project_name_th,
                            'project_id' => $project_id,
                            'type_degree' =>  $type_degree,
                            'id' => $session['pfc_id']
                        ]);
                    }
                } elseif ($type == 2) {
                    if ($type_degree == 1) {
                        return $this->render('process', [
                            'type' => $type,
                            'process' => $process,
                            'process_progress' => $process_progress,
                            'process_add' => $process_add,
                            'process_add_con' => $process_add_con,
                            'process_requirement' => $process_requirement,
                            'start_date_constant' => $start_date_constant,
                            'project_name' => $project->project_name_th,
                            'project_id' => $project_id,
                            'type_degree' =>  $type_degree,
                            'id' => $session['pfc_id']
                        ]);
                    } else {
                        return $this->render('process_master', [
                            'type' => $type,
                            'process' => $process,
                            'process_progress' => $process_progress,
                            'process_add' => $process_add,
                            'process_add_con' => $process_add_con,
                            'process_requirement' => $process_requirement,
                            'start_date_constant' => $start_date_constant,
                            'project_name' => $project->project_name_th,
                            'project_id' => $project_id,
                            'type_degree' =>  $type_degree,
                            'id' => $session['pfc_id']
                        ]);
                    }
                }
            }else{
                return $this->redirect(['process_gantt',
                    'type' => $type,
                    'process_id' => $process[0]->process_id,
                    'project_id' => $project_id,
                    'type_degree' =>  $type_degree,
                    'process_gantt_type_code' => $process_gantt_type_code,
                ]);
            }
        }
    }


    public function actionProcess_gantt($process_id,$project_id,$type_degree,$type,$process_gantt_type_code){
        $process_gantt = ProcessGantt::find()->where("process_gantt_type_code like :b ORDER BY process_gantt_no",[":b"=>$process_gantt_type_code])->all();

        $count = 1;
        $session = Yii::$app->session;

        foreach ($process_gantt as $process_gantts){
            $process_add = New ProcessAdd();
            $process_add->process_add_id = $process_id.'_process_'.strval($count).'_add_'.strval($count);
            $process_add->process_add_topic = $process_gantts->process_gantt_topic;
            $process_add->process_add_detail = $process_gantts->process_gantt_detail;
            $process_add->process_add_date_start = $process_gantts->process_gantt_date_start;
            $process_add->process_add_date_end = $process_gantts->process_gantt_date_end;
            $process_add->save();

            $process_progress = New ProcessProgress();
            $process_progress->process_progress_id = $process_id.'_progress_'.strval($count);
            $process_progress->process_progress_no = $count;
            $process_progress->process_progress_score = 0;
            $process_progress->process_progress_score_full = $process_gantts->process_gantt_score;
            $process_progress->process_progress_per = 0;
            $process_progress->process_progress_per_full = $process_gantts->process_gantt_score;
            $process_progress->process_progress_status_id = 2;
            $process_progress->process_id = $process_id;
            $process_progress->save();

            $process_progress_add = New ProcessAddConnect();
            $process_progress_add->process_add_connect_id = $process_id.'_progress_'.strval($count).'_add_'.strval($count);
            $process_progress_add->process_progress_id = $process_id.'_progress_'.strval($count);
            $process_progress_add->process_add_id = $process_id.'_process_'.strval($count).'_add_'.strval($count);
            $process_progress_add->save();

            $count++;
        }
        return $this->redirect(['process',
            'project_id' => $project_id,
            'type'=>$type,
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt_type_code,
        ]);
    }


    public function actionProcess_add(){
        $session = Yii::$app->session;
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();

        if(isset($_POST)) {
            $count_no = 1;
            $count_add_no = 1;
            $process_progress = ProcessProgress::find()->where("process_id like :b ORDER BY process_progress_no",[":b"=>$_POST['process_id']])->all();
            $process_add_con = ProcessAddConnect::find()->all();

            foreach ($process_progress as $process_progressn){
                $count_no = $process_progressn->process_progress_no;
                $count_no++;
            }

            foreach ($process_add_con as $process_add_cons){
                foreach ($process_progress as $process_progressn){
                    if($process_progressn->process_progress_id == $process_add_cons->process_progress_id){
                        $count_add_no++;
                    }
                }
            }

            //--------------------------------------------- NO.Change --------------------------------------------------

            if((int)$_POST['process_no_form'] <= $count_no) {
                $count_change_no = (int)$_POST['process_no_form'];
                foreach ($process_progress as $process_progressn_no) {
                    if ($process_progressn_no->process_progress_no == $count_change_no) {
                        $process_progress_no_change = ProcessProgress::findOne($process_progressn_no->process_progress_id);
                        $process_progress_no_change->process_progress_no = $process_progressn_no->process_progress_no + 1;
                        $process_progress_no_change->update();
                        $count_change_no++;
                    }
                }
            }

            //----------------------------------------------------------------------------------------------------------

            $process_add = New ProcessAdd();
            $process_add->process_add_id = $_POST['process_id'].'_process_'.strval($count_add_no).'_add_'.strval($count_no);
            $process_add->process_add_topic = $_POST['process_topic_form'];
            $process_add->process_add_detail = $_POST['process_detail_form'];
            $process_add->process_add_date_start = $_POST['process_date_start_form'];
            $process_add->process_add_date_end = $_POST['process_date_end_form'];
            $process_add->save();

            $process_progress = New ProcessProgress();
            $process_progress->process_progress_id = $_POST['process_id'].'_progress_'.strval($count_no);
            $process_progress->process_progress_no = (int)$_POST['process_no_form'];
            $process_progress->process_progress_per = 0;
            $process_progress->process_progress_per_full = 0;
            $process_progress->process_progress_score = 0;
            $process_progress->process_progress_score_full = 10;
            $process_progress->process_progress_status_id = 2;
            $process_progress->process_id = $_POST['process_id'];
            $process_progress->save();

            $process_progress_add = New ProcessAddConnect();
            $process_progress_add->process_add_connect_id = $_POST['process_id'].'_progress_'.strval($count_add_no).'_add_'.strval($count_add_no+1);
            $process_progress_add->process_progress_id = $_POST['process_id'].'_progress_'.strval($count_no);
            $process_progress_add->process_add_id = $_POST['process_id'].'_process_'.strval($count_add_no).'_add_'.strval($count_no);
            $process_progress_add->save();

            return $this->redirect(['process',
                'project_id' => $_POST['project_id'],
                'type'=>$_POST['type'],
                'id'=>$session->get('pfc_id'),
                'type_degree'=>$session->get('pfc_type_degree'),
                'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
            ]);

        }else if(!isset($_POST)){

        }
    }


    public function actionProcess_add_sub(){
        $session = Yii::$app->session;
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();
        $count = 0;
        $process_requirement = ProcessRequirement::find()->where("process_progress_id like :b", [":b" => $_POST['process_progress_id']])->all();

        foreach ($process_requirement as $process_requirements){
            $count++;
        }

        $process_add_sub = New ProcessRequirement();
        $process_add_sub->process_requirement_id = $_POST['process_progress_id'].'_requirement_'.strval($count+1);
        $process_add_sub->process_requirement_topic = $_POST['process_topic_form_sub'];
        $process_add_sub->process_requirement_detail = $_POST['process_detail_form_sub'];
        $process_add_sub->process_requirement_status = 2;
        $process_add_sub->process_progress_id = $_POST['process_progress_id'];
        $process_add_sub->save();

        $process_progress_status = ProcessProgress::findOne($_POST['process_progress_id']);
        if($process_progress_status->process_progress_status_id = 1) {
            $process_progress_status->process_progress_status_id = 2;
            $process_progress_status->update();
        }

        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type'=>$_POST['type'],
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);
    }


    public function actionProcess_edit(){
        $session = Yii::$app->session;
        $count_no = 1;
        $process_progress = ProcessProgress::find()->where("process_id like :b ORDER BY process_progress_no",[":b"=>$_POST['process_id']])->all();
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();

        foreach ($process_progress as $process_progressn){
            $count_no = $process_progressn->process_progress_no;
        }

        //--------------------------------------------- NO.Change --------------------------------------------------

        if((int)$_POST['edit_no_form'] <= $count_no) {
            $count_change_no = (int)$_POST['edit_no_form'];
            foreach ($process_progress as $process_progressn_no) {
                if ($process_progressn_no->process_progress_no == $count_change_no) {
                    $process_progress_no_change = ProcessProgress::findOne($process_progressn_no->process_progress_id);
                    $process_progress_no_change->process_progress_no = $process_progressn_no->process_progress_no + 1;
                    $process_progress_no_change->update();
                    $count_change_no++;
                }
            }
        }

        //----------------------------------------------------------------------------------------------------------

        $process_edit = ProcessAdd::findOne($_POST['process_add_id']);
        $process_edit->process_add_topic = $_POST['edit_topic_form'];
        $process_edit->process_add_detail = $_POST['edit_detail_form'];
        $process_edit->process_add_date_start = $_POST['edit_date_start_form'];
        $process_edit->process_add_date_end = $_POST['edit_date_end_form'];
        $process_edit->update();

        $process_progress_edit = ProcessProgress::findOne($_POST['process_progress_id']);
        $process_progress_edit->process_progress_no = (int)$_POST['edit_no_form'];
        $process_progress_edit->update();

        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type'=>$_POST['type'],
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);
    }


    public function actionProcess_edit_sub(){
        $session = Yii::$app->session;
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();
        $process_edit_sub = ProcessRequirement::findOne($_POST['edit_sub_id']);
        $process_edit_sub->process_requirement_topic = $_POST['edit_topic_form'];
        $process_edit_sub->process_requirement_detail = $_POST['edit_detail_form'];
        $process_edit_sub->update();

        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type'=>$_POST['type'],
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);
    }



    public function actionProcess_delete(){
        $session = Yii::$app->session;
        ProcessAddConnect::findOne($_POST['delete_add_con_id'])->delete();
        ProcessAdd::findOne($_POST['delete_add_id'])->delete();
        ProcessProgress::findOne($_POST['delete_progress_id'])->delete();
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();

        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type'=>$_POST['type'],
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);
    }


    public function actionProcess_delete_sub(){
        $session = Yii::$app->session;
        $process_re_con = ProcessRequirementConnect::find()->where("process_requirement_id like :b ",[":b"=>$_POST['delete_sub_id']])->all();
        if($process_re_con != null) {
            foreach ($process_re_con as $process_re_cons) {
                ProcessProgressFile::findAll($process_re_cons->process_progress_file_id);
                ProcessRequirementConnect::findOne($process_re_cons->process_requirement_con_id)->delete();
            }
        }
        ProcessRequirement::findOne($_POST['delete_sub_id'])->delete();

        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();
        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type'=>$_POST['type'],
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);
    }


    public function actionProcess_score(){

        $session = Yii::$app->session;

        $process_progress_score = ProcessProgress::findOne($_POST['process_progress_id']);
        $process_progress_score->process_progress_score = (int)$_POST['score'];;
        $process_progress_score->process_progress_score_full = (int)$_POST['score_full'];;
        $process_progress_score->update();
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();


        $process_progress = ProcessProgress::find()->where("process_id like :b ORDER BY process_progress_no", [":b" => $_POST['process_id']])->all();
        $check_progress = 0;
        $process_progree_count = 0;
        $check_progress_sum = 0;

        foreach ($process_progress as $process_progressn) {
            $process_progree_count++;
            if($process_progressn->process_progress_status_id == 1){
                $check_progress++;
            }
        }

        if($process_progress != null) {
            $check_progress_sum = $check_progress / $process_progree_count * 100;
        }


        $project_progress = Project::findOne($_POST['project_id']);
        $project_progress->project_progress = $check_progress_sum;
        $project_progress->update();

        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type'=>$_POST['type'],
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);

    }


    public function actionProcess_upload(){
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();
        date_default_timezone_set("Asia/bangkok");
        $session = Yii::$app->session;
        $file_docx = strtolower($_FILES["upload"]["name"]);
        $uploadOk = 0;
        $sur = strrchr($file_docx,".");

        $file_upload_newname = date("Ymd").$_POST['type'].$time = date("His").$sur;

        if($sur == ".docx" || $sur == ".pdf" || $sur == ".zip" || $sur == ".doc") {
            $uploadOk = 1;
        }

        if($_POST['upload_check'] == 1 && $uploadOk == 1) {
//            $process_progress_con = ProcessProgressConnect::find()->where("process_id like :b ",[":b"=>$_POST['process_progress_id']])->all();

            $progress_upload = New ProcessProgressFile();
            $progress_upload->process_progress_file_id = $_POST['process_progress_id'].date("Ymd").$_POST['type'].date("His");
            $progress_upload->process_progress_file_date = date("Y-m-d").' '.$time = date("H:i:s");
            $progress_upload->process_progress_file_name = $_FILES["upload"]["name"];
            $progress_upload->process_progress_file_persontype = $_POST['type'];
            $progress_upload->process_progress_file_progress = $file_upload_newname;
            $progress_upload->save();

            $progress_upload_con = New ProcessProgressConnect();
            $progress_upload_con->process_progress_file_id = $_POST['process_progress_id'].date("Ymd").$_POST['type'].date("His");
            $progress_upload_con->process_progress_id = $_POST['process_progress_id'];
            $progress_upload_con->process_progress_con_id = $_POST['process_progress_id'].'_con'.'_'.date("Ymd").date("His");
            $progress_upload_con->save();

            move_uploaded_file($_FILES["upload"]["tmp_name"], "../fileupload/progress_file/" . $file_upload_newname);

        }elseif ($_POST['upload_check'] == 2 && $uploadOk == 1){
            $requirement_upload = New ProcessProgressFile();
            $requirement_upload->process_progress_file_id = $_POST['process_requirement_id'].date("Ymd").$_POST['type'].date("His");
            $requirement_upload->process_progress_file_date = date("Y-m-d").' '.$time = date("H:i:s");
            $requirement_upload->process_progress_file_name = $_FILES["upload"]["name"];
            $requirement_upload->process_progress_file_persontype = $_POST['type'];
            $requirement_upload->process_progress_file_progress = $file_upload_newname;
            $requirement_upload->save();

            $requirement_upload_con = New ProcessRequirementConnect();
            $requirement_upload_con->process_progress_file_id = $_POST['process_requirement_id'].date("Ymd").$_POST['type'].date("His");
            $requirement_upload_con->process_requirement_id = $_POST['process_requirement_id'];
            $requirement_upload_con->process_requirement_con_id = $_POST['process_requirement_id'].'_con'.'_'.date("Ymd").date("His");
            $requirement_upload_con->save();

            move_uploaded_file($_FILES["upload"]["tmp_name"], "../fileupload/progress_file/" . $file_upload_newname);
        }

        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type'=>$_POST['type'],
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);

    }


    public function actionProcess_download($fileupload){
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_REQUEST['process_id']])->all();
        $session = Yii::$app->session;
        $file_url = '../fileupload/progress_file/'.$fileupload;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url);

        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type'=>$_POST['type'],
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);

    }




    public function actionProcess_pass(){
        $session = Yii::$app->session;
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();
        $process_pass = ProcessProgress::findOne($_POST['process_pro_id']);
        $process_pass->process_progress_status_id = 1;
        $process_pass->update();

        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type'=>$_POST['type'],
            'id'=>$session->get('pfc_id'),
            'type_degree'=>$session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);
    }


    public function actionProcess_re_pass(){
        $session = Yii::$app->session;
        $check_pass = 0;
        $process_gantt = Process::find()->where("process_id like :b ",[":b"=>$_POST['process_id']])->all();
        $process_re_pass = ProcessRequirement::findOne($_POST['process_re_id']);
        $process_re_pass->process_requirement_status = 1;
        $process_re_pass->update();

        $process_requirement = ProcessRequirement::find()->where("process_progress_id like :b ",[":b"=>$_POST['process_pro_id']])->all();
        foreach ($process_requirement as $process_requirements){
            if($process_requirements->process_requirement_status == 1){
                $check_pass = 1;
            }else{
                $check_pass = 0;
            }
        }

        if($check_pass == 1){
            $process_pass = ProcessProgress::findOne($_POST['process_pro_id']);
            $process_pass->process_progress_status_id = 1;
            $process_pass->update();

            return $this->redirect(['process',
                'project_id' => $_POST['project_id'],
                'type'=>$_POST['type'],
                'id'=>$session->get('pfc_id'),
                'type_degree'=>$session->get('pfc_type_degree'),
                'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
            ]);
        }


        return $this->redirect(['process',
            'project_id' => $_POST['project_id'],
            'type' => $_POST['type'],
            'id' => $session->get('pfc_id'),
            'type_degree' => $session->get('pfc_type_degree'),
            'process_gantt_type_code' => $process_gantt[0]->process_gantt_tpye_code,
        ]);
    }


}