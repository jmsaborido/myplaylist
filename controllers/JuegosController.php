<?php

namespace app\controllers;

use app\models\Generos;
use app\models\Juegos;
use app\models\JuegosSearch;
use Jschubert\Igdb\Builder\SearchBuilder;
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
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'create-api'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            return Yii::$app->user->identity['rol'] === 'ADMIN';
                        },
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
            'totalG' => Generos::lista()
        ]);
    }

    public function actionView($id)
    {

        $model = $this->findJuego($id);

        $searchBuilder = new SearchBuilder(Yii::$app->params['igdb']['key']);

        $respuesta = $searchBuilder
            ->addEndpoint('games')
            ->searchById($model->api)
            ->get();

        $searchBuilder->clear();

        $imagen = $searchBuilder
            ->addEndpoint('covers')
            ->searchById($respuesta->cover)
            ->get();


        $lista = Generos::lista();
        $out = [];
        foreach ($respuesta->genres as $value) array_push($out, $lista[$value]);
        $generos = implode(', ', $out);

        return $this->render('view', [
            'model' => $model,
            'respuesta' => $respuesta,
            'imagen' => $imagen,
            'generos' => $generos,
        ]);
    }

    public function actionCreate()
    {
        $model = new Juegos();

        if ($model->load(Yii::$app->request->post())) {
            $searchBuilder = new SearchBuilder(Yii::$app->params['igdb']['key']);

            try {
                $respuesta = $searchBuilder
                    ->addEndpoint('games')
                    ->addFields(['*'])
                    ->addSearch($model->nombre)
                    ->search()
                    ->get();
            } catch (\Throwable $th) {

                return $this->render('create', [
                    'model' => $model,
                    'noEnc' => true
                ]);
            }


            return $this->render('create', [
                'model' => $model,
                'respuesta' => $respuesta
            ]);

            // return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // public function actionUpdate($id)
    // {

    //     $model = $this->findJuego($id);
    //     if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         return ActiveForm::validate($model);
    //     }

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['index']);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //         'totalG' => Generos::lista()
    //     ]);
    // }

    public function actionDelete($id)
    {

        $model = $this->findJuego($id);
        if (Yii::$app->user->identity['rol']) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Fila borrada con éxito.');
        } else {
            Yii::$app->session->setFlash('error', 'Solo puedes borrar los juegos los administradores.');
        }

        return $this->redirect(['index']);
    }

    protected function findJuego($id)
    {
        if (($juego = Juegos::findOne($id)) === null) {
            throw new NotFoundHttpException('No se ha encontrado el juego.');
        }

        return $juego;
    }


    public function actionCreateApi($id)
    {


        $total = Juegos::find()->where(['api' => $id])->count();
        if ($total === 0) {
            $model = new Juegos();

            $searchBuilder = new SearchBuilder(Yii::$app->params['igdb']['key']);

            $respuesta = $searchBuilder
                ->addEndpoint('games')
                ->searchById($id)
                ->get();

            $searchBuilder->clear();

            if (!isset($respuesta->cover)) {
                goto terminar;
            }
            $imagen = $searchBuilder
                ->addEndpoint('covers')
                ->searchById($respuesta->cover)
                ->get();
            $model->img_api = $imagen->image_id;

            $model->api = $id;
            $model->nombre = $respuesta->name;
            $model->year_debut = isset($respuesta->first_release_date) ? date("Y",  $respuesta->first_release_date) : 0;
            if (is_array($respuesta->genres)) {
                $model->genero_id = $respuesta->genres[0];
            } else {
                $model->genero_id = $respuesta->genres;
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            terminar: return $this->goBack();
        }
    }
}
