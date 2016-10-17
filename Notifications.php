<?php

namespace suver\notifications;

use Yii;
use yii\base\Exception;
use yii\base\Object;
use suver\notifications\models\Notifications as NotificationsModel;
use suver\notifications\models\NotificationsTemplate as NotificationsTemplateModel;
use suver\notifications\Notification;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Notifications
 * @package yii2-notifications
 */
class Notifications extends Object
{

    protected static $channels = [];

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init($app) {
        parent::init();

        $module = \suver\notifications\Module::getInstance();
        if($module->channels) {
            foreach ($module->channels as $channel) {
                self::registerChannel(new $channel['class']($app, $channel['config'], $channel['init']));
            }
        }
    }

    /**
     * @param $type type of channel
     * @return mixed
     */
    public static function getChannel($channel) {
        return isset(self::$channels[$channel]) ? self::$channels[$channel] : null;
    }

    /**
     * @param $type type of channel
     * @param $channel channel configuration
     */
    public static function registerChannel($channel, $config=null) {
        if($config) {
            $channel->init($config);
        }
        self::$channels[$channel->getChannelName()] = $channel;
    }

    /**
     * Вернет настройку по ключу $key
     * @param $key ключ
     * @param $default default=null, настройка по умолчанию
     * @return Notification|null
     */
    public static function get($key, $user_id) {
        $modelTemplate = NotificationsTemplateModel::find()->andWhere(['key' => $key])->one();
        $model = new NotificationsModel();

        $module = \suver\notifications\Module::getInstance();
        $userClass = $module->identityClass;

        $user = $userClass::findOne($user_id);
        if(!$user) {
            throw new Exception('User not found');
        }

        $params = $user->attributes;

        $model->user_id = $user_id;
        $model->key_template = $modelTemplate->key;
        $model->message = $modelTemplate->template;
        $model->subject = $modelTemplate->subject;
        $model->params = $params;

        return new Notification([
            'modelTemplate' => $modelTemplate,
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * Вернет настройку по ключу $key
     * @param $key ключ
     * @param $default default=null, настройка по умолчанию
     * @return Notification|null
     */
    public static function getInstance($user_id) {

        $model = new NotificationsModel;
        $model->user_id = $user_id;

        $module = \suver\notifications\Module::getInstance();
        $userClass = $module->identityClass;

        $user = $userClass::findOne($user_id);

        return new Notification([
            'modelTemplate' => null,
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * @param $notificationId
     * @return bool|\suver\notifications\Notification
     * @throws Exception
     */
    public static function load($notificationId) {
        $model = NotificationsModel::findOne($notificationId);
        $modelTemplate = null;
        if($model->key_template) {
            $modelTemplate = NotificationsTemplateModel::find()->andWhere(['key' => $model->key_template])->one();
        }

        $module = \suver\notifications\Module::getInstance();
        $userClass = $module->identityClass;

        $user = $userClass::findOne($model->user_id);
        if (!$user) {
            throw new Exception('User not found');
        }

        $params = $user->attributes;

        if($modelTemplate) {
            $model->message = $modelTemplate->template;
            $model->subject = $modelTemplate->subject;
        }

        $model->params = ArrayHelper::merge($model->params, $params);

        return new Notification([
            'modelTemplate' => $modelTemplate,
            'model' => $model,
            'user' => $user,
        ]);

    }
}
