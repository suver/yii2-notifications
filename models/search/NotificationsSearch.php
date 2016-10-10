<?php

namespace suver\notifications\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use suver\notifications\models\Notifications;

/**
 * NotificationsSearch represents the model behind the search form about `suver\notifications\models\Notifications`.
 */
class NotificationsSearch extends Notifications
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['user_id', 'type', 'channel'], 'integer'],
            [['subject'], 'string', 'max' => 255],
            [['updated_at', 'created_at', 'viewed_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Notifications::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['id'=>SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => \suver\notifications\Module::getInstance()->defaultNotificationsPerPage,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'channel' => $this->channel,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'viewed_at' => $this->viewed_at,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject]);

        return $dataProvider;
    }
}
