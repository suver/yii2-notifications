<?php

namespace suver\notifications\models;

use suver\notifications\models\query\NotificationsTemplateQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%suver_notifications_template}}".
 *
 * @property string $key
 * @property string $language
 * @property integer $bind
 * @property string $description
 * @property string $template
 * @property string $created_at
 * @property string $updated_at
 */
class NotificationsTemplate extends \yii\db\ActiveRecord
{
    const BIND_YES = 1;
    const BIND_NO = 0;

    public static $bind = [];

    public function init() {
        static::$bind = [
            self::BIND_YES => Yii::t("common", "Закреплен"),
            self::BIND_NO => Yii::t("common", "Откреплет"),
        ];
    }

    public static function getBindTypes() {
        return static::$bind;
    }

    public static function getBindType($bind) {
        return isset(static::$bind[$bind]) ? static::$bind[$bind] : null;
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
    public static function tableName()
    {
        return '{{%suver_notifications_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'language'], 'required'],
            [['bind'], 'integer'],
            [['description', 'title', 'subject', 'template', 'params'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['key'], 'string', 'max' => 100],
            [['title', 'subject'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('common', 'Ключь'),
            'language' => Yii::t('common', 'Язык'),
            'bind' => Yii::t('common', 'Закреплено?'),
            'description' => Yii::t('common', 'Описнаие'),
            'title' => Yii::t('common', 'Название'),
            'subject' => Yii::t('common', 'Тема'),
            'template' => Yii::t('common', 'Шаблон'),
            'params' => Yii::t('common', 'Параметры'),
            'created_at' => Yii::t('common', 'Создано'),
            'updated_at' => Yii::t('common', 'Обновлено'),
        ];
    }

    /**
     * @inheritdoc
     * @return NotificationsTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationsTemplateQuery(get_called_class());
    }
}
