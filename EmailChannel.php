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
class EmailChannel implements ChannelInterface
{
    public $class;
    public $config;
    public $init;

    public function __construct($app, $config, $init) {
        $this->config = $config;
        $this->init = $init;
        $app->components = [
            'mailer' => $this->config,
        ];
    }

    public function getChannelName() {
        return 'email';
    }

    public function init($config) {
        $this->config = $config;
    }

    public function send(NotificationsModel $object, $user) {
        $message = $object->getMessage();
        $subject = $object->getSubject();

        return Yii::$app->mailer->compose()
            ->setFrom($this->init['from'])
            ->setTo($user->email)
            ->setSubject($subject)
            ->setTextBody($message)
            ->setHtmlBody(TransformationWidget::widget(['message' => $message]))
            ->send();
    }



}
