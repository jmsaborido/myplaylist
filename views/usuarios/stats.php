<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use app\helpers\Utility;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = "Estadisticas de " . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="usuarios-stats">
    <?php if (!empty($datos)) : ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-striped table-borderless detail-view'],
            'attributes' => [
                [
                    'attribute' => 'total',
                    'value' => $datos['total'],
                ],
                [
                    'attribute' => 'Cuantos NO habian sido compleatados antes',
                    'value' => $datos['anterior'],
                ],            [
                    'attribute' => 'Cuantos habian sido compleatados antes',
                    'value' => $datos['total'] - $datos['anterior'],
                ],
                [
                    'attribute' => 'Año Medio de debut de los juegos completados',
                    'value' => floor(Utility::media($datos['debut'])),
                ],
                [
                    'attribute' => 'Año de debut más comun',
                    'value' => Utility::moda($datos['debut']),
                ],
                [
                    'attribute' => 'Dia que mas juegos ha completado',
                    'value' => Utility::moda($datos['dias']),
                ],
                [
                    'attribute' => 'Mes que mas juegos ha completado',
                    'value' => Yii::$app->formatter
                        ->asDate(date("F", mktime(0, 0, 0, Utility::moda($datos['meses']))), "MMMM"),
                ],
                [
                    'attribute' => 'Año que mas juegos ha completado',
                    'value' => Utility::moda($datos['años']),
                ],
                [
                    'attribute' => 'Dia medio que mas juegos ha completado',
                    'value' => ceil(Utility::media($datos['dias'])),
                ],
                [
                    'attribute' => 'Mes medio que mas juegos ha completado',
                    'value' =>   Yii::$app->formatter
                        ->asDate(date("F", mktime(0, 0, 0, ceil(Utility::media($datos['meses'])))), "MMMM"),
                ],
                [
                    'attribute' => 'Año medio que mas juegos ha completado',
                    'value' => ceil(Utility::media($datos['años'])),
                ],
                [
                    'attribute' => 'Juegos pasados por dia',
                    'value' => $datos['diasT'] > 1 ?
                        $datos['total'] / ($datos['diasT'])
                        : "Tiene que haber pasado al menos un dia desde el primer juego completado"
                ],
                [
                    'attribute' => 'Juegos pasados por mes',
                    'value' => $datos['diasT'] > 30 ?
                        $datos['total'] / ($datos['diasT'] / 30)
                        : "Tiene que haber pasado al menos un mes desde el primer juego completado",
                ],
                [
                    'attribute' => 'Juegos pasados por año',
                    'value' => $datos['diasT'] > 365 ?
                        $datos['total'] / ($datos['diasT'] / 365)
                        : "Tiene que haber pasado al menos un año desde el primer juego completado",
                ],
            ],
        ]);
    else : ?>
        <h2><?= $model->username ?> no ha completado ningun juego </h2>
        <?= Html::a('Volver Al Perfil', ['view', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?php endif ?>
</div>