<?php

namespace app\controllers;

use Yii;
use app\models\Conversaciones;
use app\models\Mensajes;
use yii\helpers\Json;
use app\models\Usuarios;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConversacionesController implements the CRUD actions for Conversaciones model.
 */
class ConversacionesController extends Controller
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
     * Lists all Conversaciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        Conversaciones::vacias();
        $dataProvider = new ActiveDataProvider([
            'query' => Conversaciones::find()->where(['or', ['id_user1' => Yii::$app->user->id], ['id_user2' => Yii::$app->user->id]]),
            'pagination' => ['pageSize' => 5],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Conversaciones model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // $this->layout = 'Mensaje';
        $mensaje = new Mensajes();
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Mensajes::find()->where(['id_conversacion' => $id])->orderBy('created_at DESC'),
            'pagination' => ['pageSize' => 20],
        ]);
        if ($mensaje->load(Yii::$app->request->post()) && $mensaje->validate(['content'])) {
            $mensaje->id_sender = Yii::$app->user->id;
            $mensaje->id_conversacion = $id;
            $mensaje->save();
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'mensaje' => $mensaje,
            'model' => $model,
            'id' => $id,
        ]);
    }

    /**
     * Creates a new Conversaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // $this->layout = 'mensajes';
        $model = new Conversaciones();
        Yii::debug("Entramos");

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::debug("Entramos");
            $model->id_user2 = Usuarios::find()->select('id')->where(['username' => $model->username])->scalar();
            $model->id_user1 = Yii::$app->user->id;
            $conversacion = Conversaciones::find()
                ->where(['id_user1' => $model->id_user1, 'id_user2' => $model->id_user2])
                ->orWhere(['id_user2' => $model->id_user1, 'id_user1' => $model->id_user2])->one();
            if ($conversacion == null) {
                $model->save();
                $model->refresh();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->redirect(['view', 'id' => $conversacion->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Conversaciones model.
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
     * Deletes an existing Conversaciones model.
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
     * Finds the Conversaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conversaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Conversaciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionBuscarUsuario($name = null)
    {
        $users = [];
        if ($name != null || $name != '') {
            $users = Usuarios::find()
                ->select(['username'])
                ->where(['ilike', 'username', "$name"])
                ->column();
        }
        return Json::encode($users);
    }
}
