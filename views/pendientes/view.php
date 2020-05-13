<?php

use Symfony\Component\DomCrawler\Form;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Completados */

$this->title = $respuesta->name . " pendiente de completar por " . $model->usuario->username;
$this->params['breadcrumbs'][] = ['label' => 'Completados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pendientes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row mb-3">
        <div class="col text-center">
            <?= Html::img('https://images.igdb.com/igdb/image/upload/t_cover_big/' .  $model->juego->img_api . '.jpg', ['height' => '200px']) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-borderless detail-view'],
        'attributes' => [
            'pasado:boolean',
            'tengo:boolean',
            [
                'attribute' => 'consola.denom',
                'label' => 'Quiero completar en:',
            ],
            [
                'label' => 'Fecha de salida',
                'value' =>  $respuesta->first_release_date,
                'format' => 'date'
            ],
            [
                'label' => 'Todos los generos',
                'value' =>  $generos
            ],
            [
                'label' => 'Puntuacion media',
                'value' => isset($respuesta->total_rating) ? round($respuesta->total_rating) : null,
            ]
        ],
    ]) ?>

    <?php if (!Yii::$app->user->isGuest && $model->usuario_id === Yii::$app->user->id) : ?>

        <p>
            <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Marcar juego como completado', ['completados/create', 'id' => $model->juego_id, 'pasado' => $model->pasado, 'consola' => $model->consola_id, 'pend_id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif ?>











</div>
</div>