<?php

namespace app\controllers;

use app\models\Consolas;
use app\models\Generos;
use app\models\Juegos;
use app\models\JuegosSearch;
use Yii;
use yii\bootstrap4\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class JuegosController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                // 'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            return Yii::$app->user->identity->id === 1;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $JuegosSearch = new JuegosSearch();
        $dataProvider = $JuegosSearch->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'juegosSearch' => $JuegosSearch,
            'totalG' => Generos::lista(),
            'totalC' => Consolas::lista(),

        ]);
    }

    public function actionView($id)
    {
        $model = $this->findJuego($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Juegos();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'totalG' => Generos::lista(),
            'totalC' => Consolas::lista(),
        ]);
    }

    public function actionUpdate($id)
    {

        $model = $this->findJuego($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'totalG' => Generos::lista(),
            'totalC' => Consolas::lista(),
        ]);
    }

    public function actionDelete($id)
    {

        $model = $this->findJuego($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Fila borrada con éxito.');

        return $this->redirect(['index']);
    }

    protected function findJuego($id)
    {
        if (($juego = Juegos::findOne($id)) === null) {
            throw new NotFoundHttpException('No se ha encontrado el juego.');
        }

        return $juego;
    }
}
