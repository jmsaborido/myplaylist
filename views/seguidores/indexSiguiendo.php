<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SeguidoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Usuarios que siguen a ' . $searchModel->seguido->login;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seguidores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Seguidores', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'created_at:dateTime',
            [
                'attribute' => 'seguidor.login',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->seguidor->login, ['/usuarios/view', 'id' => $model->seguidor_id]);
                },
            ],            'ended_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>