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
            'options' => ['class' => 'table table-striped table-border detail-view', 'id' => 'stats'],
            'attributes' => [
                [
                    'attribute' => 'total',
                    'value' => $datos['total'],
                ],
                [
                    'attribute' => 'Cuantos NO habían sido completados antes',
                    'label' => 'Cuantos NO habían sido completados antes',
                    'value' => $datos['anterior'],
                ],            [
                    'attribute' => 'Cuantos habían sido compleatados antes',
                    'label' => 'Cuantos habían sido completados antes',
                    'value' => $datos['total'] - $datos['anterior'],
                ],
                [
                    'attribute' => 'Año Medio de debut de los juegos completados',
                    'label' => 'Año medio de debut de los juegos completados',
                    'value' => floor(Utility::media($datos['debut'])),
                ],
                [
                    'attribute' => 'Año de debut más común',
                    'label' => 'Año de debut más común',
                    'value' => Utility::moda($datos['debut']),
                ],
                [
                    'attribute' => 'Día que más juegos ha completado',
                    'label' => 'Día en el que se han completado más juegos',
                    'value' => Utility::moda($datos['dias']),
                ],
                [
                    'attribute' => 'Mes que más juegos ha completado',
                    'label' => 'Mes en el que se han completado más juegos',
                    'value' => ucfirst(Yii::$app->formatter
                        ->asDate(date("F", mktime(0, 0, 0, Utility::moda($datos['meses']))), "MMMM")),
                ],
                [
                    'attribute' => 'Año que más juegos ha completado',
                    'label' => 'Año en el que se han completado más juegos',
                    'value' => Utility::moda($datos['años']),
                ],
                [
                    'attribute' => 'Día medio que más juegos ha completado',
                    'label' => 'Día medio en el que más juegos se han completado',
                    'value' => ceil(Utility::media($datos['dias'])),
                ],
                [
                    'attribute' => 'Mes medio que más juegos ha completado',
                    'label' => 'Mes medio en el que más juegos se han completado',
                    'value' =>   ucfirst(Yii::$app->formatter
                        ->asDate(date("F", mktime(0, 0, 0, ceil(Utility::media($datos['meses'])))), "MMMM")),
                ],
                [
                    'attribute' => 'Año medio que más juegos ha completado',
                    'label' => 'Año medio en el que más juegos se han completado',
                    'value' => ceil(Utility::media($datos['años'])),
                ],
                [
                    'attribute' => 'Juegos completados por día',
                    'label' => 'Juegos completados por día',
                    'value' => $datos['diasT'] > 1 ?
                        round(
                            $datos['total'] / ($datos['diasT']),
                            2
                        )
                        : "Tiene que haber pasado al menos un día desde el primer juego completado"
                ],
                [
                    'attribute' => 'Juegos completados por mes',
                    'label' => 'Juegos completados por mes',
                    'value' => $datos['diasT'] > 30 ?
                        round(
                            $datos['total'] / ($datos['diasT'] / 30),
                            2
                        )
                        : "Tiene que haber pasado al menos un mes desde el primer juego completado",
                ],
                [
                    'attribute' => 'Juegos completados por año',
                    'label' => 'Juegos completados por año',
                    'value' => $datos['diasT'] > 365 ?
                        round($datos['total'] / ($datos['diasT'] / 365), 2)
                        : "Tiene que haber pasado al menos un año desde el primer juego completado",
                ],
            ],
        ]);
    else : ?>
        <h2><?= $model->username ?> no ha completado ningun juego </h2>
        <?= Html::a('Volver Al Perfil', ['view', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?php endif ?>
</div>