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

    <div class="completados">
        <h2>
            <?= Html::a($model->total . " " . ($model->total === 1 ? "Juego Completado" : "Juegos Completados"), ['/completados/index', 'usuario_id' => $model->id]) ?>
        </h2>
    </div>

    <div id="linea-seguidores">
        <h3>
            <?= Html::a($siguiendo . " Siguiendo", ['/seguidores/index', 'seguidor_id' => $model->id]) ?>
        </h3>
        <h3>
            <?= Html::a($seguidores . " Seguidores", ['/seguidores/index-siguiendo', 'seguido_id' => $model->id]) ?>
        </h3>
    </div>



    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-borderless detail-view'],
        'attributes' => [
            'login',
            'nombre',
            'apellidos',
            'email',
            'created_at:dateTime',
            'rol',
        ],
    ]);
    if (Yii::$app->user->id === $model->id) {

        echo (Html::a(
            'Modificar',
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-info']
        ));
        echo (Html::a(
            'Cambiar Imagen',
            ['upload', 'id' => $model->id],
            ['class' => 'btn btn-info']
        ));
    }

    ?>

</div>