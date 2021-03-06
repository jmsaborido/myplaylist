<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "juegos".
 *
 * @property int $id
 * @property int $api
 * @property string|null $img_api
 * @property string $nombre
 * @property int $genero_id
 * @property int|null $year_debut
 *
 * @property Completados[] $completados
 * @property Generos $genero
 * @property Pendientes[] $pendientes
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
            [['api', 'nombre', 'genero_id'], 'required'],
            [['api', 'genero_id', 'year_debut'], 'default', 'value' => null],
            [['api', 'genero_id', 'year_debut'], 'integer'],
            [['img_api'], 'string', 'max' => 255],
            [['nombre'], 'string', 'max' => 100],
            [['api'], 'unique'],
            [['genero_id'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::className(), 'targetAttribute' => ['genero_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['genero.denom']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'api' => 'id de la API',
            'img_api' => 'Portada',
            'nombre' => 'Nombre',
            'genero_id' => 'Genero ID',
            'year_debut' => 'Año Debut',
        ];
    }

    /**
     * Gets query for [[Completados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompletados()
    {
        return $this->hasMany(Completados::className(), ['juego_id' => 'id'])->inverseOf('juego');
    }

    /**
     * Gets query for [[Genero]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasOne(Generos::className(), ['id' => 'genero_id'])->inverseOf('juegos');
    }

    /**
     * Gets query for [[Pendientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPendientes()
    {
        return $this->hasMany(Pendientes::className(), ['juego_id' => 'id'])->inverseOf('juego');
    }
}
