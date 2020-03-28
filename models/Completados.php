<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "completados".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $juego_id
 * @property int $consola_id
 * @property string $fecha
 * @property bool|null $pasado
 *
 * @property Consolas $consola
 * @property Juegos $juego
 * @property Usuarios $usuario
 */
class Completados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'completados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'juego_id', 'consola_id'], 'required'],
            [['usuario_id', 'juego_id', 'consola_id'], 'default', 'value' => null],
            [['usuario_id', 'juego_id', 'consola_id'], 'integer'],
            [['fecha'], 'safe'],
            [['fecha'], 'default', 'value' => date("d/M/y")],
            [['pasado'], 'boolean'],
            [['consola_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consolas::className(), 'targetAttribute' => ['consola_id' => 'id']],
            [['juego_id'], 'exist', 'skipOnError' => true, 'targetClass' => Juegos::className(), 'targetAttribute' => ['juego_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['consola.denom']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'juego_id' => 'Juego ID',
            'consola_id' => 'Consola ID',
            'fecha' => 'Fecha',
            'pasado' => 'Pasado',
        ];
    }

    /**
     * Gets query for [[Consola]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsola()
    {
        return $this->hasOne(Consolas::className(), ['id' => 'consola_id']);
    }

    /**
     * Gets query for [[Juego]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJuego()
    {
        return $this->hasOne(Juegos::className(), ['id' => 'juego_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}
