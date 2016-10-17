<?php

namespace suver\notifications;

use suver\editor\TransformationWidget;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\Object;
use suver\notifications\models\Notifications as NotificationsModel;
use yii\helpers\Json;

/**
 * Class Notification
 * @package yii2-notifications
 */
class FlashNotificationsChannel implements ChannelInterface
{
    public $class;
    public $config;
    public $init;

    public function __construct($app, $config, $init) {
        $this->config = $config;
        $this->init = $init;
        //$app->components = [];
    }

    public function getChannelName() {
        return 'flash-notifications';
    }

    public function init($config) {
        $this->config = $config;
    }

    public function send(NotificationsModel $object, $user) {
        $subject = $object->getSubject();
        $message = $object->getMessage();

        Yii::$app->session->setFlash($this->init['key'], $subject . " | " . $message);
        return true;
    }



}
