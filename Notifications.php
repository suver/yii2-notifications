<?php

namespace suver\notifications;

use Yii;
use yii\base\Exception;
use yii\base\Object;
use suver\notifications\models\Notifications as NotificationsModel;
use yii\helpers\Json;

/**
 * Class Notifications
 * @package yii2-notifications
 */
class Notifications extends Object
{

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
    }

    /**
     * Вернет настройку по ключу $key
     * @param $key ключ
     * @param $default default=null, настройка по умолчанию
     * @return Notification|null
     */
    public static function get($key) {
        $setting = NotificationsModel::find()->andWhere(['key' => $key])->all();

        return new static([
            'model' => $setting
        ]);
    }

}
