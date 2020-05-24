<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SeguidoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios que sigue ' . $searchModel->seguidor->username;
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
                'attribute' => 'seguido.username',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->seguido->username, ['/usuarios/view', 'id' => $model->seguido_id]);
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>