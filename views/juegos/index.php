<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Lista de Juegos';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="generos-index">
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity['rol'] === 'ADMIN') : ?>
        <div class="row">
            <div class="col text-center">
                <?= Html::a('Añadir Juego', ['create'], ['class' => 'btn btn-lg btn-outline-success']) ?>
            </div>
        </div>
    <?php endif ?>


    <?php if ($dataProvider->totalCount) : ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $juegosSearch,
            'layout' => '{items}{pager}',
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
                    'class' => ActionColumn::class,
                ],
            ],
        ]) ?>
</div>
<?php endif ?>