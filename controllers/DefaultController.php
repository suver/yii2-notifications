<?php

namespace suver\notifications\controllers;

use suver\notifications\Notification;
use suver\notifications\Notifications;
use yii\web\Controller;

/**
 * Default controller for the `settings` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //$notifications = Notifications::get(\Yii::$app->user->getId())->setViewed();

        return $this->render('index');
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($id)
    {
        var_dump($id);exit;

        return $this->render('index');
    }
}
