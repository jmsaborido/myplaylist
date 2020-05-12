<?php

namespace app\controllers;


use Yii;
use app\models\ComentariosCompletados;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class ComentariosCompletadosController extends Controller
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
                        'actions' => ['comentar', 'delete', 'update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionComentar()
    {
        $datos = Yii::$app->request->post()['ComentariosCompletados'];
        if ($datos) {
            $model = new ComentariosCompletados();
            $model->cuerpo = $datos['cuerpo'];
            $model->usuario_id = Yii::$app->user->id;
            $model->completado_id = $datos['id'];
            $model->save();
            Yii::$app->session->setFlash('success', 'Comentario realizado con exito');
            return $this->redirect(['/completados/view', 'id' => $datos['id']]);
        }
        Yii::$app->session->setFlash('error', 'El comentario ha fallado');

        return $this->goBack();
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $id = $model->completado_id;
        $model->delete();

        return $this->redirect(['/completados/view', 'id' => $id]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/usuarios/view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = ComentariosCompletados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La pagina no existe.');
    }
}
