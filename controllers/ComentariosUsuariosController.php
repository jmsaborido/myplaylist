<?php

namespace app\controllers;


use Yii;
use app\models\ComentariosUsuarios;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class ComentariosUsuariosController extends Controller
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
        $datos = Yii::$app->request->post()['ComentariosUsuarios'];
        if ($datos) {
            $model = new ComentariosUsuarios();
            $model->cuerpo = $datos['cuerpo'];
            $model->usuario_id = Yii::$app->user->id;
            $model->perfil_id = $datos['id'];
            $model->save();
            Yii::$app->session->setFlash('success', 'Comentario realizado con exito');
            return $this->redirect(['/usuarios/view', 'id' => $datos['id']]);
        }
        Yii::$app->session->setFlash('error', 'El comentario ha fallado');

        return $this->goBack();
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $id = $model->perfil_id;
        $model->delete();

        return $this->redirect(['/usuarios/view', 'id' => $id]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/usuarios/view', 'id' => $model->perfil_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = ComentariosUsuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La pagina no existe.');
    }
}
