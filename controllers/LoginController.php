<?php
/**
 * Created by PhpStorm.
 * User: pessm
 * Date: 9/16/2017
 * Time: 5:02 AM
 */

namespace app\controllers;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;
use yii\helpers\Json;
use app\models\Teacher;
use app\models\Student;
use app\models\Personnel;
use app\models\ProjectConnect;

class LoginController extends Controller
{
    public function actionLogin($user_id)
    {
        $teacher = Teacher::find()->where("teacher_id like :b",[":b"=>$user_id])->all();
        $student = Student::find()->where("student_id like :b",[":b"=>$user_id])->all();
        $personnel = Personnel::find()->where("personnel_id like :b",[":b"=>$user_id])->all();

        if(!empty($teacher)) {
            $session = Yii::$app->session;
            foreach ($teacher as $teachers):
                echo $teachers['teacher_firstName'];
                $session->set('pfc_id', $teachers['teacher_id']);
                $session->set('pfc_type', 1);
                $session->set('pfc_name', $teachers['teacher_prefix'].' '.$teachers['teacher_firstName']);
            endforeach;
            $this->redirect(['project/project_teacher',
                'teacher_id' => $session->get('pfc_id'),
                'type_degree' =>1,
            ]);
        }elseif (!empty($student)){
            $project_con = ProjectConnect::find()->where("student_id like :b",[":b"=>$user_id])->all();
            $session = Yii::$app->session;
            foreach ($student as $students):
                echo $students['student_firstName'];
                $session->set('pfc_id', $students['student_id']);
                $session->set('pfc_type', 2);
                $session->set('pfc_name', $students['student_prefix'].' '.$students['student_firstName']);
            endforeach;
            $this->redirect(['project/project_student',
                'student_id' => $session->get('pfc_id'),
                'project_con' =>$project_con,
            ]);
        }elseif (!empty($personnel)) {
            $session = Yii::$app->session;
            foreach ($personnel as $personnels):
                echo $personnels['personnel_name'];
                $session->set('pfc_id', $personnels['personnel_id']);
                $session->set('pfc_type', 3);
                $session->set('pfc_name', $personnels['personnel_name']);
            endforeach;
            $this->redirect(['personnel/personnel_type',
                'student_id' => $session->get('pfc_id'),

            ]);
        }

    }

    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->removeAll();
        $this->redirect(['project/home']);
    }
}