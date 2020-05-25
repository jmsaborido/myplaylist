<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Juegos;



/**
 * JuegosSearch represents the model behind the search form of `app\models\Juegos`.
 */
class JuegosSearch extends Juegos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'genero_id', 'year_debut'], 'integer'],
            [['nombre', 'genero.denom'], 'safe'],
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
        $query = Juegos::find()->innerJoinWith(['genero g']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]]
        ]);
        $dataProvider->sort->attributes['genero.denom'] = [
            'asc' => ['g.denom' => SORT_ASC],
            'desc' => ['g.denom' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'genero_id' =>  $this->getAttribute('genero.denom'),
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['<', 'year_debut', $this->getAttribute('year_debut')]);



        return $dataProvider;
    }
}
