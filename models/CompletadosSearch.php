<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Completados;

/**
 * CompletadosSearch represents the model behind the search form of `app\models\Completados`.
 */
class CompletadosSearch extends Completados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'juego_id', 'consola_id', 'juego.genero_id'], 'integer'],
            [['fecha', 'consola.denom', 'juego.nombre', 'juego.year_debut', 'juego.genero.denom'], 'safe'],
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
        $query = Completados::find()->innerJoinWith(['consola c'])->innerJoinWith(['juego j'])->innerJoinWith('genero g');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['fecha' => SORT_ASC]]

        ]);
        $dataProvider->sort->attributes['consola.denom'] = [
            'asc' => ['c.denom' => SORT_ASC],
            'desc' => ['c.denom' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['juego.nombre'] = [
            'asc' => ['j.nombre' => SORT_ASC],
            'desc' => ['j.nombre' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['juego.genero.denom'] = [
            'asc' => ['g.denom' => SORT_ASC],
            'desc' => ['g.denom' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['juego.year_debut'] = [
            'asc' => ['j.year_debut' => SORT_ASC],
            'desc' => ['j.year_debut' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'usuario_id' => $this->usuario_id,
            'id' => $this->id,
            'juego_id' => $this->juego_id,
            'consola_id' => $this->getAttribute('consola.denom'),
            'j.genero_id' => $this->getAttribute('juego.genero.denom'),
            'fecha' => $this->fecha,
            'pasado' => $this->pasado,
            'j.year_debut' =>  $this->getAttribute('juego.year_debut'),
        ]);
        $query->andFilterWhere(['ilike', 'j.nombre', $this->getAttribute('juego.nombre')]);


        return $dataProvider;
    }
}
