<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

AppAsset::register($this);
$this->title = 'Conversaciones';
?>
<div class="conversacions-index">

    <p>
        <?= Html::a('Nuevo Mensaje', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'attribute' => 'receiver.username',
                'label' => 'Conversacion con:',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->receiver->username;
                }
            ],
            [
                'attribute' => 'last.message',
                'label' => 'Ultimo mensaje',
                'value' => function ($model, $key, $index, $widget) {
                    $last = $model->getLast();
                    return $last->sender->username  . ": " .  Html::encode($last->cuerpo);
                }
            ],
            [
                'attribute' => 'last.momento',
                'label' => 'fecha',
                'format' => 'DateTime',
                'value' => function ($model, $key, $index, $widget) {
                    $last = $model->getLast();
                    return $last->created_at;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
            ]
        ]

        // 'itemView' => function ($model, $key, $index, $widget) {
        //     Yii::debug($model);
        //     return $this->render('_view.php', [
        //         'model' => $model,
        //         'index' => $index,
        //     ]);
        // }
    ]) ?>
</div>