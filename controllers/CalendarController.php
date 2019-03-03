<?php
/**
 * Created by PhpStorm.
 * User: TACOS
 * Date: 18/2/2561
 * Time: 20:21
 */

namespace app\controllers;

use yii\web\Controller;
use Yii;


class CalendarController extends Controller

{
    public function actionCalendar()
    {
        return $this->render('calendar', [
        ]);
    }

    public function actionCalendar_email($email)
    {
        $session = Yii::$app->session;
        $session->set('email', $email);
        return $this->render('test', [
        ]);
    }

    public function actionCalendar_logout()
    {
        $session = Yii::$app->session;
        $session->remove('email');
        return $this->render('test', [
        ]);
    }
}