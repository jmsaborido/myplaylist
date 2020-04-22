<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Seguidores;

/**
 * SeguidoresSearch represents the model behind the search form of `app\models\Seguidores`.
 */
class SeguidoresSearch extends Seguidores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'seguidor_id', 'seguido_id'], 'integer'],
            [['created_at', 'ended_at', 'blocked_at', 'seguido.login'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Seguidores::find()->joinWith('seguido s');;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['seguido.login'] = [
            'asc' => ['s.login' => SORT_ASC],
            'desc' => ['s.login' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'ended_at' => $this->ended_at,
            'blocked_at' => $this->blocked_at,
            'seguidor_id' => $this->seguidor_id,
            'seguido_id' => $this->seguido_id,
        ]);

        $query->andFilterWhere(['ilike', 's.login', $this->getAttribute('seguido.login')]);

        return $dataProvider;
    }
}
