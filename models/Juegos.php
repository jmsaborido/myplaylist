<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "juegos".
 *
 * @property int $id
 * @property int|null $api
 * @property string|null $img_api
 * @property string $nombre
 * @property int $genero_id
 * @property int|null $year_debut
 *
 * @property Completados[] $completados
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
            [['api', 'nombre', 'genero_id'], 'required'],
            [['genero_id', 'year_debut'], 'default', 'value' => null],
            [['genero_id', 'year_debut'], 'integer'],
            [['img_api'], 'string', 'max' => 255],
            [['nombre'], 'string', 'max' => 100],
            [['genero_id'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::className(), 'targetAttribute' => ['genero_id' => 'id']],
        ];
    }

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
     * @return \yii\db\ActiveQuery
     */
    public function getCompletados()
    {
        return $this->hasMany(Completados::className(), ['juego_id' => 'id'])->inverseOf('juego');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasOne(Generos::className(), ['id' => 'genero_id'])->inverseOf('juegos');
    }
}
