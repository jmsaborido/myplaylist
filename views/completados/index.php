<?php

use kartik\date\DatePicker;
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
                    (array_keys($dataProvider->query->where)[0] === 'usuario_id'
                        && count(($dataProvider->query->where)) === 1
                        && $dataProvider->count === 0)
                        ? 'Todavia no has añadido ningun juego. Visita la lista de juegos y selecciona cual has completado'
                        : ''
                ?> </p>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
    ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view table-striped table-borderless text-center'],
        'layout' => '{items}{pager}',
        'pager' => [
            'options' => ['class' => 'pagination justify-content-center'],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'juego.img_api',
                'format' => 'html',
                'label' => '',
                'value' => function ($model) {
                    return Html::a(Html::img('https://images.igdb.com/igdb/image/upload/t_cover_small/' . $model->juego->img_api . '.jpg', ['width' => '60']), ['completados/view', 'id' => $model->id]);
                },
            ],
            [
                'attribute' => 'juego.nombre',
                'headerOptions' => ['style' => 'width:100%']
            ],
            'juego.year_debut',
            [
                'attribute' => 'consola.denom',
                'label' => 'Consola',
                'filter' => $totalC,
            ],
            'pasado:boolean',
            [
                'attribute' => 'fecha',
                'format' => 'date',
                'filter' => DatePicker::widget([
                    'readonly' => true,
                    'model' => $searchModel,
                    'attribute' => 'fecha',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy/m/dd'
                    ]
                ])
            ],


            [
                'class' => 'yii\grid\ActionColumn',
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->id === $searchModel->usuario_id,
            ],
        ],
    ]); ?>



</div>