<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seleccion".
 *
 * @property int $usuario_id
 * @property bool|null $fechas
 * @property bool|null $anterior
 * @property bool|null $debut
 *
 * @property Usuarios $usuario
 */
class Seleccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seleccion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id'], 'required'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['fechas', 'anterior', 'debut'], 'boolean'],
            [['usuario_id'], 'unique'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => 'Usuario ID',
            'fechas' => 'Fechas',
            'anterior' => 'Anterior',
            'debut' => 'Debut',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('seleccion');
    }
}
