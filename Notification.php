<?php

namespace suver\notifications;

use Yii;
use yii\base\Exception;
use yii\base\Object;
use suver\notifications\models\Notifications as NotificationsModel;
use yii\helpers\Json;

/**
 * Class Notification
 * @package yii2-notifications
 */
class Notification extends Object
{

    /**
     * @var NotificationsModel AR model
     */
    public $model;


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
     * Вернет все параметры
     * @return mixed|null
     */
    public function getParams()
    {
        return empty($this->model->params) ? [] : Json::decode($this->model->params);
    }


    /**
     * Удаляет уведомление
     * @param $default
     * @return mixed
     */
    public function delete() {
        return $this->model->delete();
    }

    /**
     * Помечает уведомление как прочитанное или отправленное
     * @param $default
     * @return Notification
     */
    public function setViewed() {
        $this->model->viewed_at = date("Y-m-d H:i:s");
        return $this;
    }

    protected function getModelErrorAsString() {
        if($this->model->hasErrors()) {
            $string = '';
            foreach($this->model->getErrors() as $error) {
                $string .= implode("", $error);
            }
            return $string;
        }
        return false;
    }

    /**
     * Вернет сообщение
     * @return string
     */
    public function getMessage() {
        return $this->model->message;
    }

    /**
     * Вернет тип сообщения
     * @return string
     */
    public function getType() {
        return $this->model->type;
    }

    /**
     * Вернет канал отправки сообщения
     * @return string
     */
    public function getChannel() {
        return $this->model->channel;
    }

}
