<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "generos".
 *
 * @property int $id
 * @property string $denom
 * @property string $created_at
 *
 * @property Juegos[] $juegos
 */
class Generos extends \yii\db\ActiveRecord
{
    private $_total = null;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'generos';
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['completados.usuario_id']);
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'denom' => 'Nombre',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Define cual es el total de juegos completados en este género
     *
     * @param int $total el total de juegos completados
     * @return void
     */
    public function setTotal($total)
    {
        $this->_total = $total;
    }

    /**
     * Devuelve el total de juegos completados en este género
     *
     * @return $_total el total de juegos completados
     */
    public function getTotal()
    {
        if ($this->_total === null && !$this->isNewRecord) {
            $this->setTotal($this->getJuegos()->count());
        }
        return $this->_total;
    }

    /**
     * Gets query for [[Juegos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJuegos()
    {
        return $this->hasMany(Juegos::className(), ['genero_id' => 'id']);
    }

    /**
     * Gets query for [[Completados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompletados()
    {
        return $this->hasMany(Completados::class, ['juego_id' => 'id'])->via('juegos');
    }

    /**
     * Busca los generos con el atributo virtual total
     *
     * @return ActiveQuery
     */
    public static function findWithTotal()
    {
        return static::find()
            ->select(['generos.*', 'COUNT(c.id) AS total'])
            ->joinWith('completados c', false)
            ->groupBy('generos.id');
    }

    /**
     * Devuelve una lista de las generos
     *
     * @return [] La lista de generos
     */
    public static function lista()
    {
        return static::find()->select('denom')->indexBy('id')->column();
    }
}
