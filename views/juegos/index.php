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
                Yii::$app->user->identity['rol'] === 'ADMIN' ?
                    Html::a(
                        'Añadir Juego',
                        ['create'],
                        ['class' => 'btn btn-lg btn-outline-success']
                    ) : ""
            ?>
        </div>
    </div>


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