<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\Requirement;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $model app\models\Student */
/* @var $model app\models\Requirement */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;


?>

<section id="middle" >
    <header id="page-header">
        <h1>รายละเอียดโครงงาน</h1>
    </header>
    <div class="padding-20">
        <h4>ไม่พบโครงงาน</h4>
    </div>