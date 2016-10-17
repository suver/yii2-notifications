<?php

namespace suver\notifications\models\query;

/**
 * This is the ActiveQuery class for [[NotificationsTemplate]].
 *
 * @see NotificationsTemplate
 */
class NotificationsTemplateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NotificationsTemplate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NotificationsTemplate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
