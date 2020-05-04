<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Completados */

$this->title = $respuesta->name . " completado por " . $model->usuario->username;
$this->params['breadcrumbs'][] = ['label' => 'Completados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="completados-view">

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
            'fecha:date',
            'pasado:boolean',
            [
                'attribute' => 'consola.denom',
                'label' => 'Completado en',
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

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>