<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguidores".
 *
 * @property int $id
 * @property string $created_at
 * @property string|null $ended_at
 * @property string|null $blocked_at
 * @property int $seguidor_id
 * @property int $seguido_id
 *
 * @property Usuarios $seguidor
 * @property Usuarios $seguido
 */
class Seguidores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguidores';
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['seguido.login']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'ended_at', 'blocked_at'], 'safe'],
            [['seguidor_id', 'seguido_id'], 'required'],
            [['seguidor_id', 'seguido_id'], 'default', 'value' => null],
            [['seguidor_id', 'seguido_id'], 'integer'],
            [['seguidor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['seguidor_id' => 'id']],
            [['seguido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['seguido_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Siguiendo desde',
            'ended_at' => 'Ended At',
            'blocked_at' => 'Blocked At',
            'seguidor_id' => 'Seguidor ID',
            'seguido_id' => 'Seguido ID',
        ];
    }

    /**
     * Gets query for [[Seguidor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidor()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'seguidor_id'])->inverseOf('seguidores');
    }

    /**
     * Gets query for [[Seguido]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguido()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'seguido_id'])->inverseOf('seguidos');
    }

    public static function estaSiguiendo($seguido_id)
    {
        $dev = Seguidores::find()->where(
            [
                'seguidor_id' => Yii::$app->user->id,
                'seguido_id' => $seguido_id,
                'ended_at' => null,
            ]
        );
        return $dev->exists();
    }
}
