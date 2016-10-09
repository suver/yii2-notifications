<?php

namespace suver\notifications\models;

use suver\notifications\models\query\NotificationsTemplateQuery;
use Yii;

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
            [['description', 'template'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['key'], 'string', 'max' => 100],
            [['language'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('common', 'Key'),
            'language' => Yii::t('common', 'Language'),
            'bind' => Yii::t('common', 'Bind'),
            'description' => Yii::t('common', 'Description'),
            'template' => Yii::t('common', 'Template'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
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
