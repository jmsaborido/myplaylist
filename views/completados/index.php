<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CompletadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Completados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="completados-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col text-center">
            <p>
                <?=
                    Html::a(
                        $dataProvider->totalCount ? 'Añadir Juego Completado' : 'Todavia no has añadido ningun juego. Pulsa este botón para crear tu lista',
                        ['completados/create'],
                        ['class' => 'btn btn-lg btn-outline-success']
                    )
                ?> </p>
        </div>
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    ?>


    <?php if ($dataProvider->totalCount) : ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => '{items}{pager}',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'juego.nombre',
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
                    'attribute' => 'juego.genero.denom',
                    'label' => 'Genero',
                ],
                [
                    'attribute' => 'fecha',
                    'format' => 'date',
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    <?php endif ?>
</div>