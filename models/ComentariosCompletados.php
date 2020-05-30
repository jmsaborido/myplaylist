<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios_completados".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $completado_id
 * @property string $cuerpo
 * @property string $created_at
 * @property string|null $edited_at
 *
 * @property Completados $completado
 * @property Usuarios $usuario
 */
class ComentariosCompletados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios_completados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'completado_id', 'cuerpo'], 'required'],
            [['usuario_id', 'completado_id'], 'default', 'value' => null],
            [['usuario_id', 'completado_id'], 'integer'],
            [['cuerpo'], 'string', 'max' => 80],
            [['created_at', 'edited_at'], 'safe'],
            [['completado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Completados::className(), 'targetAttribute' => ['completado_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'completado_id' => 'Completado ID',
            'cuerpo' => 'Cuerpo',
            'created_at' => 'Created At',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * Gets query for [[Completado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompletado()
    {
        return $this->hasOne(Completados::className(), ['id' => 'completado_id'])->inverseOf('comentariosCompletados');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('comentariosCompletados');
    }
}
