<?php

namespace app\models;

use yii\web\UploadedFile;
use \yii\imagine\Image;
use Yii;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $username
 * @property string $nombre
 * @property string $apellidos
 * @property string $password
 * @property string $email
 * @property string $created_at
 * @property string|null $token
 * @property string|null $auth_key
 * @property string|null $rol
 *
 * @property ComentariosCompletados[] $comentariosCompletados
 * @property ComentariosUsuarios[] $comentariosUsuarios
 * @property ComentariosUsuarios[] $comentariosUsuarios0
 * @property Pendientes[] $pendientes
 * @property Conversaciones[] $conversaciones
 * @property Conversaciones[] $conversaciones0
 * @property Mensajes[] $mensajes
 * @property Comentarios[] $comentarios
 * @property Completados[] $completados
 * @property Seguidores[] $seguidores
 * @property Seguidores[] $seguidos
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * Escenario de crear un usuario
     */
    const SCENARIO_CREAR = 'crear';

    /**
     * Escenario de modificar un usuario
     */
    const SCENARIO_UPDATE = 'update';

    /**
     * Total de juegos completados
     *
     * @var int
     */
    private $_total = null;


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
            [['username', 'nombre', 'apellidos', 'email'], 'required'],
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
            [['username'], 'string', 'max' => 11],
            [['nombre', 'apellidos', 'email', 'auth_key', 'rol'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['username'], 'unique'],
            [['password_repeat'], 'required', 'on' => self::SCENARIO_CREAR],
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
            'username' => 'Nombre de usuario',
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

    /**
     * Define el total de juegos completados
     *
     * @param int $total El total de juegos completados
     * @return void
     */
    public function setTotal($total)
    {
        $this->_total = $total;
    }

    /**
     * Devuelve el total de juegos completados
     *
     * @return int
     */
    public function getTotal()
    {
        if ($this->_total === null && !$this->isNewRecord) {
            $this->setTotal($this->getCompletados()->count());
        }
        return $this->_total;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Devuelve un usuario por su username
     *
     * @param string $nombre el nombre del usuario a buscar
     * @return Usuario modelo del usuario encontrado
     */
    public static function findPorNombre($nombre)
    {
        return static::findOne(['username' => $nombre]);
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * {@inheritdoc}
     */
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
                $this->rol = 'USER';
            }
        } else {
            if ($this->scenario === self::SCENARIO_UPDATE) {
                if ($this->password === '') {
                    $this->password = $this->getOldAttribute('password');
                } else {
                    $this->password = Yii::$app->security->generatePasswordHash($this->password);
                }
            }
        }
        return true;
    }

    /**
     * Busca los usuarios con el atributo virtual total
     *
     * @return ActiveQuery
     */
    public static function findWithTotal()
    {
        return static::find()
            ->select(['usuarios.*', 'COUNT(c.id) AS total'])
            ->joinWith('completados c', false)
            ->groupBy('usuarios.id');
    }

    /**
     * Gets query for [[Completados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompletados()
    {
        return $this->hasMany(Completados::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[ComentariosCompletados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentariosCompletados()
    {
        return $this->hasMany(ComentariosCompletados::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[ComentariosUsuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentariosUsuarios()
    {
        return $this->hasMany(ComentariosUsuarios::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Gets query for [[Pendientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPendientes()
    {
        return $this->hasMany(Pendientes::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }
    /**
     * Gets query for [[ComentariosUsuarios0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentariosUsuarios0()
    {
        return $this->hasMany(ComentariosUsuarios::className(), ['perfil_id' => 'id'])->inverseOf('perfil');
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

    /**
     * Gets query for [[Conversaciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConversaciones()
    {
        return $this->hasMany(Conversaciones::className(), ['id_user1' => 'id'])->inverseOf('user1');
    }

    /**
     * Gets query for [[Conversaciones0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConversaciones0()
    {
        return $this->hasMany(Conversaciones::className(), ['id_user2' => 'id'])->inverseOf('user2');
    }

    /**
     * Gets query for [[Mensajes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['id_sender' => 'id'])->inverseOf('sender');
    }

    /**
     * Devuelve los correos de los admin
     *
     * @return ActiveQuery
     */
    public static function correoAdmin()
    {
        return static::find()
            ->select('email')
            ->where(['rol' => 'ADMIN'])
            ->indexBy('id')
            ->column();
    }

    /**
     * Obtiene las estadisticas a mostrar de un usuario y si no lo ha definido lo crea
     *
     * @param int $id el id del usuario
     * @return Seleccion modelo de la seleccion de estadisticas
     */
    public static function seleccion($id = null)
    {
        $id = $id === null ? Yii::$app->user->id : $id;
        if (!Seleccion::findOne(['usuario_id' => $id])) {
            $model = new Seleccion(['usuario_id' => $id]);
            $model->save();
        }
        $seleccion = Seleccion::findOne(['usuario_id' => $id]);
        return array_merge(
            ['fechas' => $seleccion->fechas],
            ['debut' => $seleccion->debut],
            ['anterior' => $seleccion->anterior]
        );
    }
}
