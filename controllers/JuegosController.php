<?php

namespace app\controllers;

use app\helpers\Utility;
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
use app\models\RecomendarForm;
use yii\helpers\Url;

class JuegosController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
                        'actions' => ['create', 'create-api', 'recomendar'],
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

    /**
     * Lists all Juegos models.
     * @return mixed
     */
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

    /**
     * Displays a single Juegos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Creates a new Juegos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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
                    ->addFilter('first_release_date', '>', '0')
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
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Juegos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findJuego($id);
        if (Yii::$app->user->identity['rol'] == 'ADMIN') {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Fila borrada con éxito.');
        } else {
            Yii::$app->session->setFlash('error', 'Solo puedes borrar los juegos los administradores.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Juegos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Generos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findJuego($id)
    {
        if (($juego = Juegos::findOne($id)) === null) {
            throw new NotFoundHttpException('No se ha encontrado el juego.');
        }
        return $juego;
    }

    /**
     * Crea los juegos desde la API de IGDB
     *
     * @param int $id
     * @return mixed
     */
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
            Yii::$app->session->setFlash('success', $model->nombre . " se ha creado con exito");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            terminar: Yii::$app->session->setFlash('error', 'El juego no se ha podido crear');
            return $this->goBack();
        }
    }

    /**
     * Recomienda juegos mediante correo
     *
     * @param int $id El ID del juego
     * @return mixed
     */
    public function actionRecomendar($id)
    {
        $model = new RecomendarForm();
        $juego = Juegos::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $url = Url::to([
                'juegos/view',
                'id' => $juego->id,
            ], true);
            $subject = 'Te han recomendado ' . $juego->nombre;
            $body = <<<EOT
                <p>Hola $model->email te han recomendado completar $juego->nombre</p>
                <p>Mira la entrada del juego <a href="$url">aqui</a> en nuestra web</p>
            EOT;
            Utility::enviarMail($body, $model->email, $subject);
            Yii::$app->session->setFlash('success', 'Juego recomendado');
            return $this->refresh();
        }
        return $this->render('recomendar', [
            'model' => $model,
            'juego' => $juego,
        ]);
    }
}
