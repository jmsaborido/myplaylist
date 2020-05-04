<?php

namespace app\models;

use yii\web\UploadedFile;
use \yii\imagine\Image;
use Yii;
use yii\helpers\Url;

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
 *
 * @property Comentarios[] $comentarios
 * @property Completados[] $completados
 * @property Seguidores[] $seguidores
 * @property Seguidores[] $seguidos
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const SCENARIO_CREAR = 'crear';
    const SCENARIO_UPDATE = 'update';
    private $_total = null;
    const IMAGE = '@img/user.png';
    public $eventImage;



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
            [['login', 'nombre', 'apellidos', 'email'], 'required'],
            [
                ['password'],
                'required',
                'on' => [self::SCENARIO_DEFAULT, self::SCENARIO_CREAR],
            ],
            [
                ['password'],
                'trim',
                'on' => [self::SCENARIO_CREAR, self::SCENARIO_UPDATE],
            ],
            [['created_at'], 'safe'],
            [['login'], 'string', 'max' => 11],
            [['nombre', 'apellidos', 'email', 'auth_key', 'rol'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['login'], 'unique'],
            [['password_repeat'], 'required', 'on' => self::SCENARIO_CREAR],
            [['eventImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [
                ['password_repeat'],
                'compare',
                'compareAttribute' => 'password',
                'skipOnEmpty' => false,
                'on' => [self::SCENARIO_CREAR, self::SCENARIO_UPDATE],
            ],
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
            'created_at' => 'Dia de registro',
            'total' => 'Juegos completados',
            'token' => 'Token',
            'auth_key' => 'Auth Key',
            'rol' => 'Rol',
        ];
    }

    public function setTotal($total)
    {
        $this->_total = $total;
    }

    public function getTotal()
    {
        if ($this->_total === null && !$this->isNewRecord) {
            $this->setTotal($this->getCompletados()->count());
        }
        return $this->_total;
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
        } else {
            if ($this->scenario === self::SCENARIO_UPDATE) {
                if ($this->password === '') {
                    $this->password = $this->getOldAttribute('password');
                } else {
                    $this->password = $security->generatePasswordHash($this->password);
                }
            }
        }
        return true;
    }

    public function getCompletados()
    {
        return $this->hasMany(Completados::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    public static function findWithTotal()
    {
        return static::find()
            ->select(['usuarios.*', 'COUNT(c.id) AS total'])
            ->joinWith('completados c', false)
            ->groupBy('usuarios.id');
    }

    /**
     * Gets query for [[Seguidores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores()
    {
        return $this->hasMany(Seguidores::className(), ['seguidor_id' => 'id'])->inverseOf('seguidor');
    }

    /**
     * Gets query for [[Seguidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidos()
    {
        return $this->hasMany(Seguidores::className(), ['seguido_id' => 'id'])->inverseOf('seguido');
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = $this->uploadPath() . $this->id . '.' . $this->eventImage->extension;
            $this->eventImage->saveAs($path);
            $this->image = $this->id . '.' . $this->eventImage->extension;
            $this->eventImage->saveAs($this->image);

            //try delete imageFile file variable before save model

            $this->eventImage = null;

            $this->save();
            return true;
        }
        return false;
    }
    public function uploadPath()
    {
        return Url::to('@uploads/');
    }
}
