<?php

namespace app\controllers;

use Yii;
use app\models\Seguidores;
use app\models\SeguidoresSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * SeguidoresController implements the CRUD actions for Seguidores model.
 */
class SeguidoresController extends Controller
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
                        'actions' => ['index', 'index-siguiendo', 'create', 'get-seguidores', 'get-bloqueados', 'follow', 'block', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete', 'update',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $relacion = Seguidores::findOne(Yii::$app->request->get('id'));
                            if ($relacion !== null) {
                                return $relacion->seguidor_id == Yii::$app->user->identity->id;
                            }
                            return false;
                        }
                    ],
                ],
            ],
        ];
    }


    /**
     * Lists all Seguidores models.
     * @return mixed
     */
    public function actionIndex($seguidor_id)
    {
        $seguidor_id ? $seguidor_id : Yii::$app->user->id;
        $searchModel = new SeguidoresSearch(['seguidor_id' => $seguidor_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Seguidores models.
     * @return mixed
     */
    public function actionIndexSiguiendo($seguido_id)
    {
        $searchModel = new SeguidoresSearch(['seguido_id' => $seguido_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('indexSiguiendo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seguidores model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Seguidores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Seguidores();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Seguidores model.
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
        ]);
    }

    /**
     * Deletes an existing Seguidores model.
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
     * Finds the Seguidores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seguidores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seguidores::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Sigues o dejas de seguir a un usuario dependiendo si lo seguias o no.
     *
     * @param int $seguido_id el ID del usuario a seguir
     * @return void
     */
    public function actionFollow($seguido_id)
    {
        $antiguo = Seguidores::find()->andWhere([
            'seguido_id' => $seguido_id,
            'seguidor_id' => Yii::$app->user->id,
        ])->one();
        if ($antiguo) {
            $antiguo->ended_at = $antiguo->ended_at === null ? gmdate('Y-m-d H:i:s') : null;
        } else {
            $antiguo = new Seguidores(
                [
                    'seguido_id' => $seguido_id,
                    'seguidor_id' => Yii::$app->user->id
                ]
            );
        }
        $antiguo->save();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return array_merge([Seguidores::estaSiguiendo($seguido_id)], [Seguidores::find()->where(['seguido_id' => $seguido_id, 'ended_at' => null])->count()]);
    }
}
