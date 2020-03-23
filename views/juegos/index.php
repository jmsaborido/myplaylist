<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Lista de Juegos';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="generos-index">
    <div class="row">
        <div class="col text-center">
            <?=
                !Yii::$app->user->isGuest ?
                    Yii::$app->user->identity->id === $juegosSearch->usuario_id ?
                    Html::a(
                        'Añadir Juego Completado',
                        ['juegos/create'],
                        ['class' => 'btn btn-lg btn-outline-success']
                    )
                    : "" : ""
            ?>
        </div>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $juegosSearch,
        'columns' => [
            [
                'attribute' => 'fecha',
                'format' => 'date',
            ],
            [
                'attribute' => 'nombre',
                'headerOptions' => ['style' => 'width:100%']
            ],
            [
                'attribute' => 'consola.denom',
                'label' => 'Consola',
                'filter' => $totalC,
            ],
            [
                'attribute' => 'pasado',
                'label' => 'Completado anteriormente',
                'format' => 'boolean',
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
                'class' => ActionColumn::class,
                'visibleButtons' =>
                [
                    'update' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id === $juegosSearch->usuario_id : false,
                    'delete' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id === $juegosSearch->usuario_id : false,
                ]
            ],
        ],
    ]) ?>


</div>