<?php
/**
 * Created by PhpStorm.
 * User: pessm
 * Date: 11/17/2017
 * Time: 3:07 PM
 */

namespace app\controllers;
use yii\web\Controller;
use app\models\Project;
use app\models\Teacher;
use app\models\Student;
use app\models\Process;
use app\models\ProcessAdd;
use app\models\ProcessProgress;
use app\models\ProcessAddConnect;

class SummaryController extends Controller
{
    public  function  actionProject_summary($project_id){
        $process = Process::find()->where("project_id like :b",[":b"=>$project_id])->all();
        $process_progress = ProcessProgress::find()->where("process_id like :b ORDER BY process_progress_no",[":b"=>$process[0]->process_id])->all();
        $process_add = ProcessAdd::find()->all();
        $process_add_con = ProcessAddConnect::find()->all();

        return $this->render('project_summary', [
            'process_progress' => $process_progress,
            'process_add' => $process_add,
            'process_add_con' => $process_add_con,
        ]);
    }


}