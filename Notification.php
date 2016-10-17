<?php

namespace suver\notifications;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\base\Object;
use suver\notifications\models\Notifications as NotificationsModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Notification
 * @package yii2-notifications
 */
class Notification extends Component 
{

    const EVENT_AFTER_SEND = 'afterSend';

    /**
     * @var NotificationsModel AR model
     */
    public $model;

    public $modelTemplate;

    /**
     * @var User AR model
     */
    public $user;


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
        return empty($this->model->params) ? [] : $this->model->params;
    }

    /**
     * Удаляет уведомление
     * @param $default
     * @return mixed
     */
    public function delete() {
        return $this->model->delete();
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
        $channelObject = Notifications::getChannel($this->model->channel);
        if(!$channelObject) {
            throw new Exception('Incorrect channel "' . $this->model->channel . '"');
        }

        return $channelObject;
    }



    /**
     * Помечает уведомление как прочитанное или отправленное
     * @param $default
     * @return Notification
     */
    public function setSentAt() {
        $this->model->sent_at = date("Y-m-d H:i:s");
        return $this;
    }

    /**
     * Помечает уведомление как прочитанное или отправленное
     * @param $default
     * @return Notification
     */
    public function setViewedAt() {
        $this->model->viewed_at = date("Y-m-d H:i:s");
        return $this;
    }

    /**
     * Установит тему сообщения
     * @return Notification
     */
    public function setSubject($subject) {
        $this->model->subject = $subject;
        return $this;
    }

    /**
     * Установит сообщение
     * @return Notification
     */
    public function setMessage($message, $params=[]) {
        $this->model->params = ArrayHelper::merge($this->model->params, $params);
        $this->model->message = $message;
        return $this;
    }

    /**
     * Установит параметры
     * @return Notification
     */
    public function setParams($params) {
        if(!is_array($params)) {
            throw new Error("Param \$params must be an array");
        }
        $this->model->params = $params;
        return $this;
    }

    /**
     * Установит тип сообщения
     * @return Notification
     */
    public function setType($type) {
        $this->model->type = $type;
        return $this;
    }

    /**
     * Установит канал отправки сообщения
     * @return Notification
     */
    public function setChannel($channel) {

        $channelObject = Notifications::getChannel($channel);
        if(!$channelObject) {
            throw new Exception('Incorrect channel');
        }

        $this->model->channel = $channel;
        return $this;
    }

    /**
     * Отправляет сообщение выбраным способом
     * @return bool
     * @throws Exception
     */
    public function send() {
        $channelObject = $this->getChannel();
        if($this->save()) {
            if($channelObject->send($this->model, $this->user)) {
                $this->trigger(self::EVENT_AFTER_SEND);
                $this->setSentAt();
                return $this->save();
            }
            return false;
        }
        else {
            throw new Exception($this->getModelErrorAsString());
            return false;
        }
    }

    /**
     * Ставит сообщение на отправку выбраным способом
     * @return bool
     * @throws Exception
     */
    public function holdOver() {
        if($this->save()) {
            $this->trigger(self::EVENT_AFTER_SEND);
            return true;
        }
        else {
            throw new Exception($this->getModelErrorAsString());
            return false;
        }
    }

    public function sendUserChannels() {

        $channels = $this->user->getNotificationChannels();
        foreach ($channels as $channel) {
            $sendObject = clone $this;
            if($sendObject->setChannel($channel)->send()) {
                $this->trigger(self::EVENT_AFTER_SEND);
            }
        }
    }

    public function holdOverUserChannels() {

        $channels = $this->user->getNotificationChannels();
        foreach ($channels as $channel) {
            $sendObject = clone $this;
            if($sendObject->setChannel($channel)->holdOver()) {
                $this->trigger(self::EVENT_AFTER_SEND);
            }
        }
    }

    public function save() {
        return $this->model->save();
    }

    public function hasError() {
        return $this->model->hasError();
    }

    public function getErrors() {
        return $this->model->getErrors();
    }

    public function __clone() {
        $this->model = clone $this->model;
        $this->modelTemplate = clone $this->modelTemplate;
        $this->user = clone $this->user;
    }
}
