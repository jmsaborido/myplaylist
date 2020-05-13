<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;


$this->title = 'Lista de Juegos';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="generos-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest) : ?>
        <div class="row">
            <div class="col text-center">
                <p>
                    <?= Html::a('Añadir Juego', ['create'], ['class' => 'btn btn-lg btn-outline-success']) ?> </p>
            </div>
        </div>
    <?php endif ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $juegosSearch,
        'options' => ['class' => 'grid-view table-responsive table-striped table-borderless text-center'],
        'layout' => '{items}{pager}',
        'pager' => [
            'options' => ['class' => 'pagination justify-content-center'],
        ],
        'columns' => [
            [
                'attribute' => 'nombre',
            ],
            [
                'attribute' => 'genero.denom',
                'label' => 'Genero',
                'filter' => $totalG,
            ],

            [
                'attribute' => 'year_debut',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {completar} {pendiente} {delete}',
                'visible' => !Yii::$app->user->isGuest,
                'buttons' => [
                    'completar' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-check"></span>', ['completados/create', 'id' => $model->id]);
                    },
                    'pendiente' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pushpin"></span>', ['pendientes/create', 'id' => $model->id]);
                    },
                ],
            ],
        ],
    ]) ?>
</div>