<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios_usuarios".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $perfil_id
 * @property string $cuerpo
 * @property string $created_at
 * @property string|null $edited_at
 *
 * @property Usuarios $usuario
 * @property Usuarios $perfil
 */
class ComentariosUsuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios_usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'perfil_id', 'cuerpo'], 'required'],
            [['usuario_id', 'perfil_id'], 'default', 'value' => null],
            [['usuario_id', 'perfil_id'], 'integer'],
            [['cuerpo'], 'string'],
            [['created_at', 'edited_at'], 'safe'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['perfil_id' => 'id']],
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
            'perfil_id' => 'Perfil ID',
            'cuerpo' => 'Cuerpo',
            'created_at' => 'Created At',
            'edited_at' => 'Edited At',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('comentariosUsuarios');
    }

    /**
     * Gets query for [[Perfil]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'perfil_id'])->inverseOf('comentariosUsuarios0');
    }
}
