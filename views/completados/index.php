<?php

use app\models\Completados;
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
                        (array_keys($dataProvider->query->where)[0] === 'usuario_id'
                            && count(($dataProvider->query->where)) === 1
                            && $dataProvider->count === 0)
                            ? 'Todavia no has añadido ningun juego. Pulsa este botón para crear tu lista'
                            : 'Añadir Juego Completado',
                        ['completados/create'],
                        ['class' => 'btn btn-lg btn-outline-success']
                    )
                ?> </p>
        </div>
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view table-responsive table-striped table-borderless text-center'],
        'layout' => '{items}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'juego.nombre',
                'headerOptions' => ['style' => 'width:100%']
            ],
            'juego.year_debut',
            // [
            //     'attribute' => 'juego.genero.denom',
            //     'label' => 'Género',
            //     'filter' => $totalG,
            // ],
            [
                'attribute' => 'consola.denom',
                'label' => 'Consola',
                'filter' => $totalC,
            ],
            'pasado:boolean',
            'fecha:date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>


</div>