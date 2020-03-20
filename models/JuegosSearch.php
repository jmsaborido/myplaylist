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
            [['id', 'consola_id', 'genero_id', 'year_debut'], 'integer'],
            [['fecha', 'nombre', 'genero.denom', 'consola.denom'], 'safe'],
            [['pasado'], 'boolean'],
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
        $query = Juegos::find()->innerJoinWith(['consola c'])->innerJoinWith(['genero g']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['genero.denom'] = [
            'asc' => ['g.denom' => SORT_ASC],
            'desc' => ['g.denom' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['consola.denom'] = [
            'asc' => ['c.denom' => SORT_ASC],
            'desc' => ['c.denom' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // Yii: debug($query->createCommand()->rawSql());
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'consola_id' => $this->getAttribute('consola.denom'),
            'pasado' => $this->pasado,
            'genero_id' =>  $this->getAttribute('genero.denom'),

        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['<', 'year_debut', $this->getAttribute('year_debut')]);



        return $dataProvider;
    }
}
