<?php

namespace suver\notifications;

use Yii;
use yii\base\Exception;
use yii\base\Object;
use suver\settings\models\Settings as SettingsModel;
use yii\helpers\Json;

/**
 * Class Notifications
 * @package yii2-settings
 */
class Notifications extends Object
{


    /**
     * @var SettingsModel AR model
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
     * Вернет настройку по ключу $key
     * @param $key ключ
     * @param $default default=null, настройка по умолчанию
     * @return Settings|null
     */
    public static function get($key) {
        $setting = SettingsModel::find()->andWhere(['key' => $key])->one();
        if (!$setting) {
            $setting = new SettingsModel;
            $setting->key = $key;
        }
        return new static([
            'model' => $setting
        ]);
    }

    /**
     * Вернет все параметры настройки
     * @return mixed|null
     */
    public function params()
    {
        return empty($this->model->params) ? [] : Json::decode($this->model->params);
    }

    /**
     * Вернет все параметры настройки
     * @return mixed|null
     */
    public function param($default) {

        switch ($this->model->type) {

            case static::TYPE_ARRAY:
                return empty($this->model->value) ? $default : Json::decode($this->model->value, true) ;
                break;

            case static::TYPE_INT:
                $value = empty($this->model->value) ? $default : $this->model->value ;
                return (int) $value;
                break;

            case static::TYPE_FILE:
            case static::TYPE_PARAM:
            case static::TYPE_OPTIONS:
            case static::TYPE_VARCHAR:
            case static::TYPE_TEXT:
            default:
                return empty($this->model->value) ? $default : $this->model->value ;;
        }
    }

    /**
     * Вернет значение настройки
     * @param $default
     * @return mixed
     */
    public function set($value) {
        switch ($this->model->type) {

            case static::TYPE_PARAM:
                return $this->_setParam($value);
                break;

            case static::TYPE_OPTIONS:
                return $this->_setOption($value);
                break;

            case static::TYPE_ARRAY:
                return $this->_setArray($value);
                break;

            case static::TYPE_VARCHAR:
                return $this->_setVarchar($value);
                break;

            case static::TYPE_TEXT:
                return $this->_setText($value);
                break;

            case static::TYPE_INT:
                return $this->_setInt($value);
                break;

            case static::TYPE_FILE:
                return $this->_setFile($value);
                break;

            default:
                return $this->_setUnknown($value);

        }
    }

    /**
     * Удаляет настройку
     * @param $default
     * @return mixed
     */
    public function delete() {
        return $this->model->delete();
    }

    /**
     * Удаляет значение настройки
     * @param $default
     * @return mixed
     */
    public function clear() {
        $this->model->value = null;
        return $this->model->save();
    }

    protected function _setParam($value) {
        $params = $this->params();
        if(isset($params[$value])) {
            $this->model->value = $value;
            if(!$this->model->save()) {
                throw new Exception($this->getModelErrorAsString());
            }
            return true;
        }
        else {
            throw new Exception('Incorrect value for param');
        }
    }

    protected function _setOption($value) {
        $params = $this->params();
        if(isset($params[$value])) {
            $this->model->value = $value;
            if(!$this->model->save()) {
                throw new Exception($this->getModelErrorAsString());
            }
            return true;
        }
        else {
            throw new Exception('Incorrect value for param');
        }
    }

    protected function _setText($value) {
        if(is_string($value)) {
            $this->model->value = $value;
            if(!$this->model->save()) {
                throw new Exception($this->getModelErrorAsString());
            }
            return true;
        }
        else {
            throw new Exception('Incorrect value');
        }
    }

    protected function _setVarchar($value) {
        if(is_string($value) && strlen($value) <= 255) {
            $this->model->value = $value;
            if(!$this->model->save()) {
                throw new Exception($this->getModelErrorAsString());
            }
            return true;
        }
        else {
            throw new Exception('Incorrect value');
        }
    }

    protected function _setArray($value) {
        if(is_array($value)) {
            $this->model->value = Json::encode($value);
            if(!$this->model->save()) {
                throw new Exception($this->getModelErrorAsString());
            }
            return true;
        }
        else {
            throw new Exception('Incorrect value');
        }
    }

    protected function _setInt($value) {
        if(is_numeric($value)) {
            $this->model->value = $value;
            if(!$this->model->save()) {
                throw new Exception($this->getModelErrorAsString());
            }
            return true;
        }
        else {
            throw new Exception('Incorrect value');
        }
    }

    protected function _setFile($value) {
        if(is_string($value) && strlen($value) <= 255) {
            $this->model->value = $value;
            if(!$this->model->save()) {
                throw new Exception($this->getModelErrorAsString());
            }
            return true;
        }
        else {
            throw new Exception('Incorrect value');
        }
    }

    protected function _setUnknown($value) {
        if(is_string($value)) {
            $this->model->value = $value;
            if(!$this->model->save()) {
                throw new Exception($this->getModelErrorAsString());
            }
            return true;
        }
        else {
            throw new Exception('Incorrect value');
        }
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
     * Вернет значение настройки
     * @param $default
     * @return mixed
     */
    public function value($default) {
        $params = $this->params();

        switch ($this->model->type) {

            case static::TYPE_PARAM:
            case static::TYPE_OPTIONS:
                $value = empty($this->model->value) ? $default : $this->model->value ;
                return isset($params[$value]) ? $params[$value] : null;
                break;

            case static::TYPE_ARRAY:
                return empty($this->model->value) ? $default : Json::decode($this->model->value, true) ;
                break;

            case static::TYPE_VARCHAR:
            case static::TYPE_TEXT:
                return empty($this->model->value) ? $default : $this->model->value ;
                break;

            case static::TYPE_INT:
                $value = empty($this->model->value) ? $default : $this->model->value ;
                return (int) $value;
                break;

            case static::TYPE_FILE:
                return empty($this->model->value) ? $default : $this->model->value ;
                break;

            default:
                $value = empty($this->model->value) ? $default : $this->model->value ;
                return $value;
        }
    }

    /**
     * конфигурация настройки
     * @param int $type
     * @param array $params
     * @param bool $private
     * @return $this
     */
    public function configure($type = self::TYPE_VARCHAR, $params=[], $private = false) {
        if ($private) {
            $user_id = Yii::$app->user->getId();
            if(!$user_id) {
                throw new Exception("User not authorized or model yii/web/User not instance");
            }
        }
        else {
            $user_id = NULL;
        }

        $this->model->type = $type;
        $this->model->params = Json::encode($params);
        $this->model->user_id = $user_id;
        if(!$this->model->save()) {
            throw new Exception($this->model->getErrors());
        }

        return $this;
    }

}
