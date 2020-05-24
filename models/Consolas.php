<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consolas".
 *
 * @property int $id
 * @property string $denom
 * @property string|null $created_at
 *
 * @property Completados[] $completados
 * @property Pendientes[] $pendientes
 */
class Consolas extends \yii\db\ActiveRecord
{
    private $_total = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consolas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denom'], 'required'],
            [['created_at'], 'safe'],
            [['denom'], 'string', 'max' => 255],
            [['denom'], 'unique'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['completados.usuario_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'denom' => 'Nombre',
            'created_at' => 'Añadido en',
        ];
    }

    /**
     * Define cual es el total de juegos completados en esta consola
     *
     * @param int $total el total de juegos completados
     * @return void
     */
    public function setTotal($total)
    {
        $this->_total = $total;
    }

    /**
     * Devuelve el total de juegos completados en esta consola
     *
     * @return $_total el total de juegos completados
     */
    public function getTotal()
    {
        if ($this->_total === null && !$this->isNewRecord) {
            $this->setTotal($this->getCompletados()->count());
        }
        return $this->_total;
    }

    /**
     * Gets query for [[Completados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompletados()
    {
        return $this->hasMany(Completados::className(), ['consola_id' => 'id'])->inverseOf('consola');;
    }

    /**
     * Gets query for [[Pendientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPendientes()
    {
        return static::find()
            ->select(['consolas.*', 'COUNT(c.id) AS total'])
            ->joinWith('completados c', false)
            ->groupBy('consolas.id');
    }

    /**
     * Busca las consolas con el atributo virtual total
     *
     * @return ActiveQuery
     */
    public static function findWithTotal()
    {
        return static::find()
            ->select(['consolas.*', 'COUNT(c.id) AS total'])
            ->joinWith('completados c', false)
            ->groupBy('consolas.id');
    }

    /**
     * Devuelve una lista de las consolas
     *
     * @return [] La lista de consolas
     */
    public static function lista()
    {
        return static::find()->select('denom')->indexBy('id')->column();
    }
}
