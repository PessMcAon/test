<?php

namespace app\module\test5\controllers;

use yii\web\Controller;

/**
 * Default controller for the `test5` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
