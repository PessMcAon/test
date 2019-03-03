<?php

use app\models\Student;
use app\models\ProjectConnect;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Yii::$app->view->params['title'] = 'Home'

?>

<section id="middle" class="section">
    <header id="page-header">
        <h1><?= $this->params['title'] ?></h1>
    </header>

    <?php
    $session = Yii::$app->session;
            echo  $session->get('name');

    ?>

</section>

