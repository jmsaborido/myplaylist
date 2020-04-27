<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Juegos */

$this->title = $respuesta->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="juegos-view">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity['rol'] === 'ADMIN') : ?>


    <?php endif ?>

    <div class="row mb-3">
        <div class="col text-center">
            <?= Html::img('https://images.igdb.com/igdb/image/upload/t_cover_big/' . $imagen->image_id . '.jpg') ?>
        </div>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-borderless detail-view'],
        'attributes' => [
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
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>