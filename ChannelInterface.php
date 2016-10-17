<?php

namespace suver\notifications;

use suver\notifications\models\Notifications as NotificationsModel;
use Yii;

/**
 * Interface ChannelInterface
 * @package yii2-notifications
 */
interface ChannelInterface
{
    public function __construct($app, $config, $init);

    public function getChannelName();

    public function init($config);

    public function send(NotificationsModel $object, $user);

}
