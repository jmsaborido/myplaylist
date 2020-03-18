<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $login
 * @property string $nombre
 * @property string $apellidos
 * @property string $password
 * @property string $email
 * @property string $created_at
 * @property string|null $token
 * @property string|null $auth_key
 * @property string|null $rol
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const SCENARIO_CREAR = 'crear';

    public $password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'nombre', 'apellidos', 'password', 'email'], 'required'],
            [['created_at'], 'safe'],
            [['login'], 'string', 'max' => 11],
            [['nombre', 'apellidos', 'email', 'auth_key', 'rol'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['login'], 'unique'],
            [['password_repeat'], 'required', 'on' => self::SCENARIO_CREAR],
            [['password'], 'compare', 'on' => self::SCENARIO_CREAR],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'password' => 'Contraseña',
            'password_repeat' => 'Repetir contraseña',
            'email' => 'Email',
            'created_at' => 'Created At',
            'token' => 'Token',
            'auth_key' => 'Auth Key',
            'rol' => 'Rol',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public static function findPorNombre($nombre)
    {
        return static::findOne(['login' => $nombre]);
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREAR) {
                $security = Yii::$app->security;
                $this->auth_key = $security->generateRandomString();
                $this->token = $security->generateRandomString(32);
                $this->password = $security->generatePasswordHash($this->password);
            }
        }

        return true;
    }
}
