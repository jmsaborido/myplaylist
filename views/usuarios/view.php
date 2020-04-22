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
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Ver Seguidos', ['/seguidores/index', 'seguidor_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-borderless detail-view'],
        'attributes' => [
            'login',
            'nombre',
            [
                'attribute' => 'siguiendo',
                'value' => $siguiendo,
            ],    [
                'attribute' => 'seguidores',
                'value' => $seguidores
            ],
            'apellidos',
            'email:email',
            'total',
            'created_at',
            'rol',
        ],
    ]) ?>

</div>