<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\IncidenciasForm;
use app\models\Usuarios;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays Incidencias page.
     *
     * @return Response|string
     */
    public function actionIncidencias()
    {
        $model = new IncidenciasForm();
        if ($model->load(Yii::$app->request->post())) {

            $actual = Yii::$app->formatter->asDatetime(time());
            $body = <<<EOT
                <h2>Incidencia.<h2>
                <p>Nombre del usuario que la ha enviado: $model->name</p>
                <p>Correo del usuario que la ha enviado: $model->email</p>
                <p>Asunto: $model->subject</p>
                <p>Cuerpo: $model->body</p>
                <p>Hora de la incidencia: $actual</p>

            EOT;
            $correos = Usuarios::correoAdmin();
            foreach ($correos as $key => $value) {
                $this->enviarMail($body, $value);
            }

            Yii::$app->session->setFlash('Incidencia Enviada');
            return $this->refresh();
        }
        return $this->render('incidencias', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        // if ($model->load(Yii::$app->request->post())) {
        //     $url = Url::to([
        //         'usuarios/activar',
        //         'id' => $model->id,
        //         'token' => $model->token,
        //     ], true);

        //     $body = <<<EOT
        //         <h2>Pulsa el siguiente enlace para confirmar la cuenta de correo.<h2>
        //         <a href="$url">Confirmar cuenta</a>
        //     EOT;
        //     $this->enviarMail($body, $model->email);
        //     Yii::$app->session->setFlash('success', 'Se ha creado el usuario correctamente.');
        //     return $this->redirect(['site/login']);
        // }
        return $this->render('about');
    }
    public function enviarMail($cuerpo, $dest)
    {
        return Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['smtpUsername'])
            ->setTo($dest)
            ->setSubject("Incidencia ADMIN myplaylist")
            ->setHtmlBody($cuerpo)
            ->send();
    }
}
