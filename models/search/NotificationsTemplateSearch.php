<?php

namespace suver\notifications\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use suver\notifications\models\NotificationsTemplate;

/**
 * BookCatalogSearch represents the model behind the search form about `common\modules\books\models\Catalog`.
 */
class NotificationsTemplateSearch extends Catalog
{
    public $authors;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bind'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['key'], 'string', 'max' => 100],
            [['language'], 'string', 'max' => 10],
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
        $query = NotificationsTemplate::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['id'=>SORT_DESC],
                'attributes' => [
                    'key',
                    'language',
                    'bind',
                ]
            ],
            'pagination' => [
                'pageSize' => \Yii::$app->getModule('books')->params['defaultNotificationsTemplatePerPage'],
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
            'bind' => $this->bind,
            'language' => $this->language,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
