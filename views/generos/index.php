<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GenerosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Generos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generos-index">
    <h1><?= Html::encode($this->title) ?></h1>
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

            'denom',
            [
                'attribute' => 'total',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->total, [
                        'completados/index', 'CompletadosSearch[juego.genero.denom]' => $model->id
                    ]);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>