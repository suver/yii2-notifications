<?php

namespace suver\notifications\models;

use suver\notifications\models\query\NotificationsQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%suver_notifications}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string $message
 * @property string $params
 * @property integer $channel
 * @property string $updated_at
 * @property string $created_at
 * @property string $viewed_at
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suver_notifications}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['message', 'subject', 'params'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['key_template'], 'string', 'max' => 100],
            [['channel'], 'string', 'max' => 50],
            [['updated_at', 'created_at', 'viewed_at', 'sent_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('suver/notifications', 'ID'),
            'user_id' => Yii::t('suver/notifications', 'ID пользователя'),
            'key_template' => Yii::t('suver/notifications', 'Ключ шаблона уведомления'),
            'subject' => Yii::t('suver/notifications', 'Тема'),
            'message' => Yii::t('suver/notifications', 'Сообщение'),
            'params' => Yii::t('suver/notifications', 'Параметры'),
            'channel' => Yii::t('suver/notifications', 'Канал'),
            'updated_at' => Yii::t('suver/notifications', 'Обновлено'),
            'created_at' => Yii::t('suver/notifications', 'Создано'),
            'viewed_at' => Yii::t('suver/notifications', 'Прочитанно'),
            'sent_at' => Yii::t('suver/notifications', 'Отправлено'),
        ];
    }

    /**
     * @inheritdoc
     * @return NotificationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationsQuery(get_called_class());
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if(parent::beforeValidate()) {

            $this->params = Json::encode($this->params);

            return true;
        }

        return  false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->params = Json::decode($this->params);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->params = Json::decode($this->params);
    }

    public function getSubject() {
        $params = $this->params;
        $subject = $this->subject;

        if($params && is_array($params)) {
            foreach ($params as $key => $value) {
                $subject = str_replace('{{'.$key.'}}', $value, $subject);
            }
        }
        return $subject;
    }

    public function getMessage() {
        $params = $this->params;
        $message = $this->message;

        if($params && is_array($params)) {
            foreach ($params as $key => $value) {
                $message = str_replace('{{'.$key.'}}', $value, $message);
            }
        }
        return $message;
    }



}
