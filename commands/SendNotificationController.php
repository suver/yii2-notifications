<?php
/**
 * Created by IntelliJ IDEA.
 * User: suver
 * Date: 09.10.16
 * Time: 0:34
 */
namespace suver\notifications\commands;

use yii\console\Controller;

class SendNotificationController extends Controller
{
    public $message;

    public function options()
    {
        return ['message'];
    }

    public function optionAliases()
    {
        return ['m' => 'message'];
    }

    public function actionIndex()
    {
        echo $this->message . "\n";
    }
}
