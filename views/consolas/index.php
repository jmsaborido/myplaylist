<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsolasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consolas';
$this->params['breadcrumbs'][] = $this->title;
Yii::debug(date('h:i:s a', time()))

?>
<div class="consolas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity['rol'] === 'ADMIN') : ?>
        <div class="row">
            <div class="col text-center">
                <p>
                    <?= Html::a('Añadir Consola', ['create'], ['class' => 'btn btn-lg btn-outline-success']) ?> </p>
            </div>
        </div>
    <?php endif ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view table-responsive table-striped table-borderless text-center'],
        'layout' => '{items}{pager}',
        'pager' => [
            'options' => ['class' => 'pagination justify-content-center'],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'denom',
            [
                'attribute' => 'total',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->total, [
                        'completados/index', 'CompletadosSearch[consola.denom]' => $model->id
                    ]);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>