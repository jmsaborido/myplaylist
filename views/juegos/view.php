<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Juegos */

$this->title = $respuesta->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<main itemscope itemtype="http://schema.org/VideoGame" class="juegos-view">


    <h1 itemprop="name"><?= Html::encode($this->title) ?></h1>

    <div class="row mb-3">
        <div itemprop="image" class="col text-center">
            <?= Html::img('https://images.igdb.com/igdb/image/upload/t_cover_big/' . $imagen->image_id . '.jpg') ?>
        </div>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-borderless detail-view'],
        'attributes' => [
            [
                'label' => 'Fecha de salida',
                'value' =>  "<span itemprop='dateCreated'>" . Yii::$app->formatter->asDate($respuesta->first_release_date) . "</span>",
                'format' => 'raw'
            ],
            [
                'label' => 'Todos los generos',
                'value' =>  $generos
            ],
            [
                'label' => 'Puntuacion media',
                'value' => isset($respuesta->total_rating) ? "<span itemprop='aggregateRating'>" . round($respuesta->total_rating) . "</span>" : null,
                'format' => 'raw'
            ]
        ],
    ]) ?>

    <p>
        <?= Html::a('Marcar Juego como Completado', ['completados/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Marcar Juego como Pendiente', ['pendientes/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Recomendar juego', ['juegos/recomendar', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</main>