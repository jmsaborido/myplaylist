<?php

namespace app\controllers;

use app\models\Consolas;
use app\models\Generos;
use app\models\Juegos;
use Yii;
use app\models\Pendientes;
use app\models\PendientesSearch;
use Jschubert\Igdb\Builder\SearchBuilder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;


/**
 * PendientesController implements the CRUD actions for Pendientes model.
 */
class PendientesController extends Controller
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
        ];
    }

    /**
     * Lists all Pendientes models.
     * @return mixed
     */
    public function actionIndex($usuario_id = null)
    {
        $usuario_id = $usuario_id === null ? Yii::$app->user->id : $usuario_id;
        $searchModel = new PendientesSearch(['usuario_id' => $usuario_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalC' => Consolas::lista(),
            'totalG' => Generos::lista(),
        ]);
    }

    /**
     * Displays a single Pendientes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

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
            'respuesta' => $respuesta,
            'generos' => $generos,
        ]);
    }

    /**
     * Creates a new Pendientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Pendientes(['usuario_id' => Yii::$app->user->id]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'totalC' => Consolas::lista(),
            'juego' => Juegos::findOne(['id' => $id])
        ]);
    }

    /**
     * Updates an existing Pendientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'totalC' => Consolas::lista(),
        ]);
    }

    /**
     * Deletes an existing Pendientes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pendientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pendientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pendientes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
