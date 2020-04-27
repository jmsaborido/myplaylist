<?php

use app\models\Seguidores;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->isGuest || (Yii::$app->user->id === $model->id) ? ""
            : Html::a(
                !Seguidores::estaSiguiendo($model->id) ?
                    'Seguir' : 'Dejar de seguir',
                ['seguidores/follow', 'seguido_id' => $model->id],
                ['class' => 'btn btn-info']
            )
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-borderless detail-view'],
        'attributes' => [
            'login',
            'nombre',
            [
                'attribute' => 'siguiendo',
                'label' => 'Siguiendo a',
                'format' => 'raw',
                'value' =>  Html::a($siguiendo, ['/seguidores/index', 'seguidor_id' => $model->id]),
            ],
            [
                'attribute' => 'seguidores',
                'format' => 'raw',
                'value' =>  Html::a($seguidores, ['/seguidores/index-siguiendo', 'seguido_id' => $model->id]),
            ],
            'apellidos',
            'email:email',
            'total',
            'created_at',
            'rol',
        ],
    ]) ?>
    <?= Yii::$app->user->id === $model->id ? Html::a(
        'Modificar',
        ['update', 'id' => $model->id],
        ['class' => 'btn btn-info']
    ) : "" ?>
</div>