<?php

use app\models\Student;
use app\models\ProjectConnect;
use app\models\ProcessProgress;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Yii::$app->view->params['title'] = 'Home'

?>

<section id="middle" class="section">
    <header id="page-header">
        <h1><?= $this->params['title'] ?></h1>
    </header>

    <?php
        echo $s;
        echo $ss;
    ?>

</section>

