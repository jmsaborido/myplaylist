<?php

namespace app\controllers;

use app\models\Completados;
use app\models\Seguidores;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class UsuariosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['registrar'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    // everything else is denied by default
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
            'siguiendo' => Seguidores::find()->where(['seguidor_id' => $id, 'ended_at' => null],)->count(),
            'seguidores' => Seguidores::find()->where(['seguido_id' => $id, 'ended_at' => null])->count(),
        ]);
    }


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
            $this->enviarMail($body, $model->email);
            Yii::$app->session->setFlash('success', 'Se ha creado el usuario correctamente.');
            return $this->redirect(['site/login']);
        }

        return $this->render('registrar', [
            'model' => $model,
        ]);
    }

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
    public function enviarMail($cuerpo, $dest)
    {
        return Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['smtpUsername'])
            ->setTo($dest)
            ->setSubject("Confirmar Cuenta")
            ->setHtmlBody($cuerpo)
            ->send();
    }

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
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página no existe.');
    }
    public function actionUpload($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->eventImage = UploadedFile::getInstance($model, 'eventImage');
            if ($model->upload()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();
    //     return $this->redirect(['index']);
    // }

    public function actionStats($id = null)
    {
        $id = $id === null ? Yii::$app->user->id : $id;

        return $this->render('stats', [
            'datos' => Completados::obtenerDatos($id),
            'model' => $this->findModel($id)
        ]);
    }
}
