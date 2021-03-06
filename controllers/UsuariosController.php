<?php

namespace app\controllers;

use app\helpers\Utility;
use app\models\ComentariosUsuarios;
use app\models\Completados;
use app\models\Seguidores;
use app\models\Seleccion;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsuariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['registrar', 'update'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'actions' => ['update', 'seleccion'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            return Yii::$app->user->id == Yii::$app->request->get()['id'];
                        },
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Usuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model2' => new ComentariosUsuarios(['usuario_id' => Yii::$app->user->id]),
            'siguiendo' => Seguidores::find()->where(['seguidor_id' => $id, 'ended_at' => null])->count(),
            'seguidores' => Seguidores::find()->where(['seguido_id' => $id, 'ended_at' => null])->count(),
            'comentarios' => ComentariosUsuarios::find()->where(['perfil_id' => $id])->orderBy('created_at')->all()
        ]);
    }

    /**
     * Registra los usuarios y les envia un correo de confirmacion
     *
     * @return mixed
     */
    public function actionRegistrar()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREAR]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $url = Url::to([
                'usuarios/activar',
                'id' => $model->id,
                'token' => $model->token,
            ], true);
            $body = <<<EOT
                <h2>Pulsa el siguiente enlace para confirmar la cuenta de correo.<h2>
                <a href="$url">Confirmar cuenta</a>
            EOT;
            $subject = 'Confirmar Cuenta';
            Utility::enviarMail($body, $model->email, $subject);
            Yii::$app->session->setFlash('success', 'Se ha creado el usuario correctamente.');
            return $this->redirect(['site/login']);
        }
        return $this->render('registrar', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id = null)
    {
        if ($id === null) {
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('error', 'Debe estar logueado.');
                return $this->goHome();
            } else {
                $model = Yii::$app->user->identity;
            }
        } else {
            $model = Usuarios::findOne($id);
        }
        $model->scenario = Usuarios::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se ha modificado correctamente.');
            return $this->goHome();
        }
        $model->password = '';
        $model->password_repeat = '';
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Comprueba que el token del usuario es el mismo que el token recibido y valida al usuario
     *
     * @param int $id el ID del usuario
     * @param string $token el token a comprobar
     * @return mixed
     */
    public function actionActivar($id, $token)
    {
        $usuario = $this->findModel($id);
        if ($usuario->token === $token) {
            $usuario->token = null;
            $usuario->save();
            Yii::$app->session->setFlash('success', 'Usuario validado. Inicie sesión.');
            return $this->redirect(['site/login']);
        }
        Yii::$app->session->setFlash('error', 'La validación no es correcta.');
        return $this->redirect(['site/index']);
    }
    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('La página no existe.');
    }

    /**
     * Renderiza la vista de las estadisticas de un usuario
     *
     * @param int $id el ID del usuario
     * @return mixed
     */
    public function actionStats($id = null)
    {
        $id = $id === null ? Yii::$app->user->id : $id;
        $seleccion = Usuarios::seleccion($id);
        return $this->render('stats', [
            'datos' => Completados::obtenerDatos($id, $seleccion),
            'model' => $this->findModel($id),
            'seleccion' => $seleccion
        ]);
    }

    /**
     * Renderiza un formulario para seleccionar que estadisticas mostrar
     *
     * @return mixed
     */
    public function actionSeleccion()
    {
        $id = Yii::$app->user->id;
        Usuarios::seleccion($id);
        $model = Seleccion::findOne(['usuario_id' => $id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se ha modificado correctamente.');
            return $this->redirect(['stats', ['id' => $id]]);
        }
        return $this->render('seleccion', [
            'model' => $model
        ]);
    }
}
