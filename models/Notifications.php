<?php

namespace suver\notifications\models;

use suver\notifications\models\query\NotificationsQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

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
            [['user_id', 'type', 'channel'], 'integer'],
            [['message', 'subject', 'params'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['updated_at', 'created_at', 'viewed_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'ID пользователя'),
            'type' => Yii::t('common', 'Тип'),
            'subject' => Yii::t('common', 'Тема'),
            'message' => Yii::t('common', 'Сообщение'),
            'params' => Yii::t('common', 'Параметры'),
            'channel' => Yii::t('common', 'Канал'),
            'updated_at' => Yii::t('common', 'Обновлено'),
            'created_at' => Yii::t('common', 'Создано'),
            'viewed_at' => Yii::t('common', 'Прочитанно'),
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
}
