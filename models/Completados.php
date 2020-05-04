<?php

namespace app\models;

use Jschubert\Igdb\Builder\SearchBuilder;
use Yii;

/**
 * This is the model class for table "completados".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $juego_id
 * @property int $consola_id
 * @property string $imagen_id
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
            [['fecha', 'juego.img_api'], 'safe'],
            [['fecha'], 'default', 'value' => date("d/M/y")],
            [['pasado'], 'boolean'],
            [['consola_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consolas::className(), 'targetAttribute' => ['consola_id' => 'id']],
            [['juego_id'], 'exist', 'skipOnError' => true, 'targetClass' => Juegos::className(), 'targetAttribute' => ['juego_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

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
            'fecha' => 'Completado el dia...',
            'pasado' => '¿Habia sido completado antes?',
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

    public function setImagenId()
    {
        if ($this->imagen_id === null && !$this->isNewRecord) {

            $searchBuilder = new SearchBuilder(Yii::$app->params['igdb']['key']);
            $respuesta = $searchBuilder
                ->addEndpoint('games')
                ->searchById($this->juego_id)
                ->get();
            $searchBuilder->clear();

            $imagen = $searchBuilder
                ->addEndpoint('covers')
                ->searchById($respuesta->cover)
                ->get();
            $searchBuilder->clear();
            $this->imagen_id = $imagen->image_id;
            $this->save();
        }
    }

    public function getImagenId()
    {
        if ($this->imagen_id === null && !$this->isNewRecord) {
            $this->setImagenId();
        }
        return $this->imagen_id;
    }


    /**
     * Gets query for [[Juego]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJuego()
    {
        return $this->hasOne(Juegos::className(), ['id' => 'juego_id'])->inverseOf('completados');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('completados');
    }


    public function getGenero()
    {
        return $this->hasMany(Generos::class, ['id' => 'genero_id'])->via('juego')->inverseOf('completados');
    }
}
