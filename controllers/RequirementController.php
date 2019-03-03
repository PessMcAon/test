<?php
/**
 * Created by PhpStorm.
 * User: pessm
 * Date: 7/19/2017
 * Time: 11:31 PM
 */

namespace app\controllers;

use Yii;
use app\models\Project;
use app\models\Requirement;
use app\models\Student;
use yii\web\Controller;


class RequirementController extends Controller
{
    public function actionRequirement($project_id)
    {
        $requirement = Requirement::find()->where("project_id like :b",[":b"=>$project_id])->all();
        return $this->render('requirement', [
            'requirement' => $requirement,
            'requirement_id'=>$project_id,
        ]);
    }

    public function actionRequirement_add()
    {
        if(isset($_POST)) {
            $requirement_add = New Requirement();
            $requirement_add->requirement_topic = $_POST['requirement_topic_form'];
            $requirement_add->requirement_detail = $_POST['requirement_detail_form'];
            $requirement_add->requirement_date = $_POST['requirement_date_form'];
            $requirement_add->requirement_file = 'test';
            $requirement_add->requirement_status = 2;
            $requirement_add->project_id = $_POST['project_id'];
            $requirement_add->save();
            return $this->redirect(['requirement', 'project_id' => $requirement_add->project_id]);
        }else if(!isset($_POST['requirement_topic_form'])){

        }
    }

    public function actionRequirement_delete($requirement_id,$project_id)
    {
        Requirement::findOne($requirement_id)->delete();
        return $this->redirect(['requirement', 'project_id' => $project_id]);
    }

    public function actionRequirement_update()
    {
        $requirement_id_update = $_POST['requirement_id'];
        if(isset($_POST)) {
            $requirement_edit = Requirement::findOne($requirement_id_update);
            $requirement_edit->requirement_id = $_POST['requirement_id'];
            $requirement_edit->requirement_topic = $_POST['requirement_topic_edit'];
            $requirement_edit->requirement_detail = $_POST['requirement_detail_edit'];
            $requirement_edit->requirement_date = $_POST['requirement_date_edit'];
            $requirement_edit->requirement_file = 'test';
            $requirement_edit->requirement_status = 2;
            $requirement_edit->project_id = $_POST['project_id'];
            $requirement_edit->update();
            return $this->redirect(['requirement', 'project_id' => $_POST['project_id']]);
        }else{

        }
    }

}