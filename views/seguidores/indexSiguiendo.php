<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SeguidoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Usuarios que siguen a ' . $searchModel->seguido->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seguidores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'created_at:dateTime',
            [
                'attribute' => 'seguidor.username',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->seguidor->username, ['/usuarios/view', 'id' => $model->seguidor_id]);
                },
            ],            'ended_at',

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>