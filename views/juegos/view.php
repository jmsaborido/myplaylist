<?php


use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use Jschubert\Igdb\Builder\SearchBuilder;
use yii\bootstrap4\Carousel;

/* @var $this yii\web\View */
/* @var $model app\models\Juegos */

$searchBuilder = new SearchBuilder(Yii::$app->params['igdb']['key']);
$searchBuilder2 = new SearchBuilder(Yii::$app->params['igdb']['key']);
$searchBuilder3 = new SearchBuilder(Yii::$app->params['igdb']['key']);
$searchBuilder4 = new SearchBuilder(Yii::$app->params['igdb']['key']);

$respuesta = $searchBuilder
    ->addEndpoint('games')
    ->searchById($model->id)
    ->get();

$genero = $searchBuilder2
    ->addEndpoint('genres')
    ->searchById($respuesta->genres[0])
    ->get();

// $tiempo = $searchBuilder3
//     ->addEndpoint('time_to_beats')
//     ->searchById($respuesta->time_to_beat, ['*'])
//     ->get();

$imagen = $searchBuilder4
    ->addEndpoint('covers')
    ->searchById($respuesta->cover)
    ->get();

Yii::debug($respuesta);

$this->title = $respuesta->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="juegos-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity['rol'] === 'ADMIN') : ?>

        <p>
            <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif ?>

    <div class="row">
        <div class="col text-center">
            <?= Html::img('https://images.igdb.com/igdb/image/upload/t_cover_big/' . $imagen->image_id . '.jpg') ?>
        </div>
    </div>

    <ul>
        <li><?= $respuesta->summary ?></li>
        <li>Puntuacion media: <?= round($respuesta->rating) ?></li>
        <li><?= $genero->name ?></li>
        <li>Fecha de salida: <?= Yii::$app->formatter->asDate($respuesta->first_release_date) ?></li>
    </ul>


</div>