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
            [['id', 'usuario_id', 'juego_id', 'consola_id'], 'integer'],
            [['fecha', 'consola.denom', 'juego.nombre', 'juego.genero_id'], 'safe'],
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
        $query = Completados::find()->innerJoinWith(['consola c'])->innerJoinWith(['juego j']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['consola.denom'] = [
            'asc' => ['c.denom' => SORT_ASC],
            'desc' => ['c.denom' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['juego.nombre'] = [
            'asc' => ['j.nombre' => SORT_ASC],
            'desc' => ['j.nombre' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['juego.genero_id'] = [
            'asc' => ['j.genero_id' => SORT_ASC],
            'desc' => ['j.genero_id' => SORT_DESC],
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
            'usuario_id' => $this->usuario_id,
            'juego_id' => $this->juego_id,
            'consola_id' => $this->getAttribute('consola.denom'),
            'fecha' => $this->fecha,
            'pasado' => $this->pasado,
        ]);

        return $dataProvider;
    }
}
