<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendientes".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $juego_id
 * @property int $consola_id
 * @property bool|null $pasado
 * @property bool|null $tengo
 *
 * @property Consolas $consola
 * @property Juegos $juego
 * @property Usuarios $usuario
 */
class Pendientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendientes';
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
            [['juego.img_api'], 'safe'],
            [['pasado', 'tengo'], 'boolean'],
            [['consola_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consolas::className(), 'targetAttribute' => ['consola_id' => 'id']],
            [['juego_id'], 'exist', 'skipOnError' => true, 'targetClass' => Juegos::className(), 'targetAttribute' => ['juego_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['consola.denom'], ['juego.nombre'], ['juego.year_debut'], ['genero.denom'], ['juego.genero_id'], ['juego.genero.denom'], ['juego.img_api']);
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
            'pasado' => '¿Habia sido completado antes?',
            'tengo' => '¿Lo tengo?',
        ];
    }

    /**
     * Gets query for [[Consola]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsola()
    {
        return $this->hasOne(Consolas::className(), ['id' => 'consola_id'])->inverseOf('pendientes');
    }

    /**
     * Gets query for [[Juego]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJuego()
    {
        return $this->hasOne(Juegos::className(), ['id' => 'juego_id'])->inverseOf('pendientes');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('pendientes');
    }

    /**
     * Gets query for [[Genero]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasMany(Generos::class, ['id' => 'genero_id'])->via('juego')->inverseOf('completados');
    }
}
