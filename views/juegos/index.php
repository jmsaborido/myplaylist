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
                Html::a(
                    $dataProvider->totalCount ? 'Añadir Juego Completado' : 'Todavia no has añadido ningun juego. Pulsa este botón para crear tu lista',
                    ['juegos/create'],
                    ['class' => 'btn btn-lg btn-outline-success']
                )
            ?>
        </div>
    </div>


    <?php if ($dataProvider->totalCount) : ?>
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
                ],
            ],
        ]) ?>
</div>
<?php endif ?>