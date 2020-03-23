<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "juegos".
 *
 * @property int $id
 * @property string|null $fecha
 * @property string $nombre
 * @property int $consola_id
 * @property bool|null $pasado
 * @property int $genero_id
 * @property int|null $year_debut
 * @property int $usuario_id
 * @property Usuarios $usuario
 * @property Consolas $consola
 * @property Generos $genero
 */
class Juegos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'juegos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha'], 'safe'],
            [['fecha'], 'default', 'value' => date("d/M/y")],
            [['nombre', 'consola_id', 'genero_id', 'usuario_id'], 'required'],
            [['consola_id', 'genero_id', 'year_debut', 'usuario_id'], 'default', 'value' => null],
            [['consola_id', 'genero_id', 'year_debut', 'usuario_id'], 'integer'],
            [['pasado'], 'boolean'],
            [['nombre'], 'string', 'max' => 100],
            [['consola_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consolas::className(), 'targetAttribute' => ['consola_id' => 'id']],
            [['genero_id'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::className(), 'targetAttribute' => ['genero_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['genero.denom'], ['consola.denom']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'nombre' => 'Nombre',
            'consola_id' => 'Consola ID',
            'pasado' => 'Pasado',
            'genero_id' => 'Genero ID',
            'year_debut' => 'Año Debut',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsola()
    {
        return $this->hasOne(Consolas::className(), ['id' => 'consola_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasOne(Generos::className(), ['id' => 'genero_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}
