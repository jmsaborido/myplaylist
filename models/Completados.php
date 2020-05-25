<?php

namespace app\models;

use DateTime;
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
 * @property ComentariosCompletados[] $comentariosCompletados
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


    /**
     * Gets query for [[ComentariosCompletados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentariosCompletados()
    {
        return $this->hasMany(ComentariosCompletados::className(), ['completado_id' => 'id'])->inverseOf('completado');
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

    /**
     * Gets query for [[Genero]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasMany(Generos::class, ['id' => 'genero_id'])->via('juego')->inverseOf('completados');
    }

    /**
     * Obtiene los datos para calcular las estadisticas a mostrar de un usuario
     *
     * @param int $id El ID del usuario
     * @return [] $datos Los datos calculados
     */
    public static function obtenerDatos($id)
    {
        $datos['debut'] = static::find()
            ->select('juegos.year_debut')
            ->joinWith('juego')
            ->where(['usuario_id' => $id])
            ->indexBy('id')
            ->column();
        $datos['total'] = count($datos['debut']);
        if ($datos['total'] === 0) {
            return [];
        }
        $datos['anterior'] = static::find()
            ->where(['usuario_id' => $id, 'pasado' => false])
            ->count();
        $datos['fecha'] = static::find()
            ->select('fecha')
            ->where(['usuario_id' => $id])
            ->indexBy('id')
            ->column();
        foreach ($datos['fecha'] as $key => $value) {
            $value = new DateTime($value);
            $datos['años'][$key] = $value->format('Y');
            $datos['meses'][$key] = $value->format('m');
            $datos['dias'][$key] = $value->format('d');
        }
        $hoy = new DateTime();
        $datos['diasT'] = $hoy
            ->diff(new DateTime($datos['fecha'][array_key_first($datos['fecha'])]))
            ->days;
        return $datos;
    }
}
