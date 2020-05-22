<?php

namespace app\controllers;

use app\models\ComentariosCompletados;
use Yii;
use app\models\Completados;
use app\models\CompletadosSearch;
use app\models\Consolas;
use app\models\Generos;
use app\models\Juegos;
use app\models\Pendientes;
use Jschubert\Igdb\Builder\SearchBuilder;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;



/**
 * CompletadosController implements the CRUD actions for Completados model.
 */
class CompletadosController extends Controller
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
                // 'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            $model = Completados::findOne(Yii::$app->request->get()['id']);
                            return Yii::$app->user->id === $model->usuario_id;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    /**
     * Lists all Completados models.
     * @return mixed
     */
    public function actionIndex($usuario_id = null)
    {
        $usuario_id = $usuario_id === null ? Yii::$app->user->id : $usuario_id;
        $searchModel = new CompletadosSearch(['usuario_id' => $usuario_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalC' => Consolas::lista(),
            'totalG' => Generos::lista(),
        ]);
    }

    /**
     * Displays a single Completados model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findCompletado($id);
        $model2 = new ComentariosCompletados(['usuario_id' => Yii::$app->user->id]);
        $comentarios = ComentariosCompletados::find()->where(['completado_id' => $id])->orderBy('created_at')->all();

        $searchBuilder = new SearchBuilder(Yii::$app->params['igdb']['key']);

        $respuesta = $searchBuilder
            ->addEndpoint('games')
            ->searchById($model->juego->api)
            ->get();

        $searchBuilder->clear();

        $lista = Generos::lista();
        $out = [];
        foreach ($respuesta->genres as $value) array_push($out, $lista[$value]);
        $generos = implode(', ', $out);

        return $this->render('view', [
            'model' => $model,
            'model2' => $model2,
            'respuesta' => $respuesta,
            'generos' => $generos,
            'comentarios' => $comentarios
        ]);
    }

    /**
     * Creates a new Completados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $pasado = null, $consola = null, $pend_id = null)
    {
        $model = new Completados(['usuario_id' => Yii::$app->user->id]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (isset(Yii::$app->request->post()['Pendientes'])) {
                Pendientes::findOne(['id' => Yii::$app->request->post()['Pendientes']['id']])->delete();
            }
            return $this->redirect(['index']);
        }

        $pendiente = new Pendientes(['id' => $pend_id, 'juego_id' => $id, 'pasado' => $pasado, 'consola_id' => $consola]);

        return $this->render('create', [
            'model' => $model,
            'totalC' => Consolas::lista(),
            'juego' => Juegos::findOne(['id' => $id]),
            'pendiente' => $pendiente
        ]);
    }

    /**
     * Updates an existing Completados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findCompletado($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'totalC' => Consolas::lista()
        ]);
    }

    /**
     * Deletes an existing Completados model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findCompletado($id);
        if ($model->usuario_id === Yii::$app->user->id) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Fila borrada con éxito.');
        } else {
            Yii::$app->session->setFlash('error', 'Solo puedes borrar tus juegos.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Completados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Completados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCompletado($id)
    {
        if (($model = Completados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
